const visits = $('.dataTable')
const visitsUrl = `${BASE_URL}/api/visit-bill`
let selectedVisitId = null;
let selectedTotalPrice = 0;

const getInitData = () => {
    visits.DataTable({
        processing: true,
        serverSide: true,
        ajax: visitsUrl,
        order: [[0, 'desc']],
        columns: [
            {
                "orderable": true,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'nama', name: 'nama'},
            {data: 'visit_type', name: 'visit_type'},
            {data: 'visit_date', name: 'visit_date'},
            {data: 'status_bayar', name: 'status_bayar'},
            {data: 'aksi', name: 'aksi'},
        ]
    });
}

$(function () {
    getInitData()
})

const reloadDatatable = table => table.DataTable().ajax.reload(null, false);

$(document).on('click', '.btn-payment', function () {
    const visitId = $(this).data('id');
    selectedVisitId = visitId;

    $.get(`${visitsUrl}/${visitId}`, function (res) {
        $('#paymentModal').modal('show');

        $('#patientName').text(res.patient_name ?? '-');
        $('#visitType').text(res.visit.visit_type ?? '-');
        $('#visitDate').text(res.visit.visit_date ?? '-');

        $('#treatmentsList').empty();
        if (res.treatments && res.treatments.name) {
            $('#treatmentsList').append(`
                <li>${res.treatments.name} - Rp ${res.treatments.price.toLocaleString()}</li>
            `);
        } else {
            $('#treatmentsList').append(`<li>Tidak ada tindakan</li>`);
        }

        $('#prescriptionsList').empty();
        if (res.prescriptions && res.prescriptions.length > 0) {
            res.prescriptions.forEach(p => {
                const name = p.medicine?.name ?? 'Obat tidak diketahui';
                const qty = p.quantity ?? 0;
                const price = p.medicine?.price ?? 0;
                $('#prescriptionsList').append(`
                    <li>${name} (x${qty}) - Rp ${(price).toLocaleString()}</li>
                `);
            });
        } else {
            $('#prescriptionsList').append(`<li>Tidak ada resep obat</li>`);
        }

        const total = res.total_price ?? 0;
        selectedTotalPrice = total;
        $('#totalBill').text(`Rp ${total.toLocaleString()}`);
    });
});

$('#btnBayar').on('click', function () {
    if (!selectedVisitId) {
        toastr.error('Visit tidak ditemukan');
        return;
    }

    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const data = {
        visit_id: selectedVisitId,
        total: selectedTotalPrice
    };

    $.ajax({
        url: visitsUrl,
        method: 'POST',
        dataType: 'json',
        data: data,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (res) {
            toastr.success(res.message, 'Pembayaran Berhasil');
            $('#paymentModal').modal('hide');
            reloadDatatable(visits);
        },
        error: function (err) {
            toastr.error('Terjadi kesalahan saat menyimpan pembayaran', 'Error');
        }
    });
});


