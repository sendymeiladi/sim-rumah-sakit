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

            $.get(`${visitsUrl}/${selectedVisitId}`, function (res) {
                let treatmentsList = '';
                if (res.treatments && res.treatments.name) {
                    treatmentsList += `
                        <tr>
                            <td>${res.treatments.name}</td>
                            <td>1</td>
                            <td>Rp ${res.treatments.price.toLocaleString()}</td>
                        </tr>`;
                }

                let prescriptionsList = '';
                if (res.prescriptions && res.prescriptions.length > 0) {
                    res.prescriptions.forEach(p => {
                        const name = p.medicine?.name ?? 'Obat tidak diketahui';
                        const qty = p.quantity ?? 0;
                        const price = p.medicine?.price ?? 0;
                        prescriptionsList += `
                            <tr>
                                <td>${name}</td>
                                <td>${qty}</td>
                                <td>Rp ${price.toLocaleString()}</td>
                            </tr>`;
                    });
                }

                const total = res.total_price ?? 0;

                const invoiceHtml = `
                    <div id="dynamicInvoice" style="padding: 20px; font-family: 'Arial', sans-serif; max-width: 700px; margin: auto;">
                        <div style="border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; text-align:center;">
                            <h2 style="margin:0;">SIM RS</h2>
                            <p style="margin:0;">Jl. Sesama, Bandung</p>
                            <p style="margin:0;">Telp: (021) 12345678</p>
                        </div>

                        <h3 style="text-align:center; margin-bottom: 20px;">INVOICE PEMBAYARAN</h3>

                        <p><strong>Nama Pasien:</strong> ${res.patient_name ?? '-'}</p>
                        <p><strong>Jenis Kunjungan:</strong> ${res.visit.visit_type ?? '-'}</p>
                        <p><strong>Tanggal Kunjungan:</strong> ${res.visit.visit_date ?? '-'}</p>

                        <hr style="margin: 20px 0;" />

                        <h4 style="margin-bottom: 10px;">Tindakan:</h4>
                        <ul style="list-style: none; padding: 0;">
                            ${
                                res.treatments && res.treatments.name
                                    ? `<li>${res.treatments.name} - Rp ${res.treatments.price.toLocaleString()}</li>`
                                    : '<li><em>Tidak ada tindakan</em></li>'
                            }
                        </ul>

                        <h4 style="margin: 20px 0 10px;">Resep Obat:</h4>
                        <ul style="list-style: none; padding: 0;">
                            ${
                                (res.prescriptions && res.prescriptions.length > 0)
                                    ? res.prescriptions.map(p => {
                                        const name = p.medicine?.name ?? 'Obat tidak diketahui';
                                        const qty = p.quantity ?? 0;
                                        const price = p.medicine?.price ?? 0;
                                        return `<li>${name} (x${qty}) - Rp ${price.toLocaleString()}</li>`;
                                    }).join('')
                                    : '<li><em>Tidak ada resep</em></li>'
                            }
                        </ul>

                        <hr style="margin: 20px 0;" />

                        <div style="text-align:right;">
                            <h3>Total Pembayaran: Rp ${total.toLocaleString()}</h3>
                        </div>

                        <div style="margin-top:30px; text-align:center;">
                            <p>Terima kasih atas kunjungan Anda.</p>
                        </div>
                    </div>
                `;

                $('body').append(invoiceHtml);
                $('#dynamicInvoice').printThis({
                    importCSS: true,
                    afterPrint: function () {
                        $('#dynamicInvoice').remove();
                    }
                });
            });
        },
        error: function (err) {
            toastr.error('Terjadi kesalahan saat menyimpan pembayaran', 'Error');
        }
    });
});



