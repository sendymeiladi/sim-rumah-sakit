const visits = $('.dataTable')
const visitsUrl = `${BASE_URL}/api/visit-prescription`

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
            {data: 'aksi', name: 'aksi'},
        ]
    });
}

$(function () {
    getInitData()
})

const reloadDatatable = table => table.DataTable().ajax.reload(null, false);

let medicineIndex = 1;

$(document).on('click', '.btn-prescription', function () {
    const visitId = $(this).data('id');
    $('#visit_id').val(visitId);
    $('#prescriptionModal').modal('show');
    $('#medicine-container').html('');
    medicineIndex = 0;
    addMedicineRow();
});

function addMedicineRow() {
    if (typeof medicineOptionsHtml === 'undefined') {
        console.error('medicineOptionsHtml belum didefinisikan!');
        return; // Stop proses kalau belum ada
    }

    $('#medicine-container').append(`
        <div class="medicine-item row mb-2">
          <div class="col-md-4">
            <select name="medicines[${medicineIndex}][medicine_id]" class="form-control">
              ${medicineOptionsHtml} <!-- Inject dari server (nanti dijelaskan) -->
            </select>
          </div>
          <div class="col-md-3">
            <input type="number" name="medicines[${medicineIndex}][quantity]" class="form-control" placeholder="Jumlah">
          </div>
          <div class="col-md-5">
            <input type="text" name="medicines[${medicineIndex}][usage_instructions]" class="form-control" placeholder="Aturan pakai">
          </div>
        </div>
    `);
    medicineIndex++;
}

$('#addMedicineRow').click(function () {
    addMedicineRow();
});

$('#prescriptionForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: visitsUrl,
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            toastr.success(res.message);
            $('#prescriptionModal').modal('hide');
        },
        error: err => {
            toastr.error(err.responseJSON?.message || 'Terjadi kesalahan');
        }
    });
});


