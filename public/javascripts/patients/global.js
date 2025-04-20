const patients = $('.dataTable')
const patientsUrl = `${BASE_URL}/api/patients`

const getInitData = () => {
    patients.DataTable({
        processing: true,
        serverSide: true,
        ajax: patientsUrl,
        order: [[0, 'desc']],
        columns: [
            {
                "orderable": true,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'name', name: 'name'},
            {data: 'nik', name: 'nik'},
            {data: 'birth_date', name: 'birth_date'},
            {data: 'gender', name: 'gender'},
            {data: 'address', name: 'address'},
            {data: 'wilayah', name: 'wilayah'},
            {data: 'phone', name: 'phone'},
            {data: 'aksi', name: 'aksi'},
        ]
    });
}

$(function () {
    getInitData()
})


const reloadDatatable = table => table.DataTable().ajax.reload(null, false);

$(document).on('click', '.btn-register', function () {
    const id = $(this).data('id');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        title: 'Daftarkan Pasien?',
        text: "Pasien akan didaftarkan untuk kunjungan",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Daftarkan!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
            cancelButton: 'btn btn-label-secondary waves-effect'
        },
        buttonsStyling: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: `${patientsUrl}/visit`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    patient_id: id
                },
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(patients);
                },
                error: err => {
                    const message = err.responseJSON?.message || 'Terjadi kesalahan';
                    toastr.error(message, 'Gagal');
                }
            });
        }
    });
});
