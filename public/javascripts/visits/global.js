const visits = $('.dataTable')
const visitsUrl = `${BASE_URL}/api/visits`
const addButton = $('#buttonAdd')
const modalTitle = $('.title')
const submitButton = $('#submit-button')


const formConfig = {
    fields: [
        {
            id: 'name',
            name: 'Nama'
        },
        {
            id: 'nik',
            name: 'NIK'
        },
        {
            id: 'birth_date',
            name: 'Tanggal Lahir'
        },
        {
            id: 'gender',
            name: 'Jenis Kelamin'
        },
        {
            id: 'address',
            name: 'Alamat'
        },
        {
            id: 'region_id',
            name: 'Wilayah'
        },
        {
            id: 'phone',
            name: 'Telepon'
        },
    ]
}


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

const resetForm = () => formConfig.fields.forEach(({id}) => $(`#${id}`).val(''))

$(function () {
    addButton.on('click', function () {
        modalTitle.text('Tambah Kunjungan Baru')
        submitButton.text('Tambah')
        resetForm()
        $('#addVisitsButton').modal('show');
    })

    $('#addVisitsButton').on('hidden.bs.modal', function () {
        resetForm();
        $(this).find('.invalid-feedback').text('');
    });
})

submitButton.on('click', function () {
    const id = $('#id').val()
    $(this).text().toLowerCase() === "ubah" ? update(id) : store()
})
const store = () => {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: visitsUrl,
        method: 'POST',
        dataType: 'json',
        data: dataForm(),
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addVisitsButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(visits);
        },
        error: ({responseJSON}) => {
            toastr.error('nik sudah digunakan', 'Error');
        }
    });
}


const dataForm = () => {
    return {
        name: $('#name').val(),
        nik: $('#nik').val(),
        birth_date: $('#birth_date').val(),
        gender: $('#gender').val(),
        address: $('#address').val(),
        region_id: $('#region').val(),
        phone: $('#phone').val(),
    };
}

const reloadDatatable = table => table.DataTable().ajax.reload(null, false);

const handleError = (responseJSON) => {
    const {errors} = responseJSON


    formConfig.fields.forEach(({id}) => {
        if (!errors.hasOwnProperty(id)) {
            $('#' + id).removeClass('is-invalid')
        } else {
            $(`#${id}`).addClass("is-invalid").next().text(errors[id][0]);
        }
    })
}

$(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        title: 'Anda Yakin?',
        text: "Data yang dihapus tidak bisa dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak',
        customClass: {
            confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
            cancelButton: 'btn btn-label-secondary waves-effect'
        },
        buttonsStyling: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: `${visitsUrl}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(visits);
                }
            });
        }
    });
});
