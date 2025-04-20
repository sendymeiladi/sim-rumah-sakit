const user = $('.dataTable')
const userUrl = `${BASE_URL}/api/manage-user`
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
            id: 'username',
            name: 'Username'
        },
        {
            id: 'password',
            name: 'Password'
        },
        {
            id: 'access',
            name: 'Akses'
        },

    ]
}


const getInitData = () => {
    user.DataTable({
        processing: true,
        serverSide: true,
        ajax: userUrl,
        columns: [
            {
                "orderable": false,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'name', name: 'name'},
            {data: 'username', name: 'username'},
            {data: 'role', name: 'role'},
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
        modalTitle.text('Tambah User')
        submitButton.text('Tambah')
        resetForm()
        $('#addUserButton').modal('show');
    })

    $('#addUserButton').on('hidden.bs.modal', function () {
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
        url: userUrl,
        method: 'POST',
        dataType: 'json',
        data: dataForm(),
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addUserButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(user);
        },
        error: ({responseJSON}) => {
            toastr.error(responseJSON, 'Error');
        }
    });
}

const update = id => {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const formData = dataForm();

    $.ajax({
        url: `${userUrl}/${id}`,
        method: 'PUT',
        dataType: 'json',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addUserButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(user);
        },
        error: ({responseJSON, status}) => {
            console.error('Error updating residential block:', responseJSON, status);
            toastr.error('Username sudah digunakan.', 'Error');
        }
    });
}

const dataForm = () => {
    console.log({
        name: $('#name').val(),
        username: $('#username').val(),
        password: $('#password').val(),
        role: $('#role').val(),
    });

    return {
        name: $('#name').val(),
        username: $('#username').val(),
        password: $('#password').val(),
        role: $('#role').val(),
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

$(document).on('click', '.btn-edit', function () {
    const userId = $(this).data('id');
    $.ajax({
        url: `${userUrl}/${userId}`,
        method: 'GET',
        dataType: 'json',
        success: res => {
            $('#id').val(res.id);
            submitButton.text('Ubah');
            modalTitle.text('Ubah User');

            $.each(res, function(key, value) {
                $(`#${key}`).val(value);
            });

            $('#residential').val(res.id_residential);

            $('#addUserButton').modal('show');
        },
        error: err => {
            console.log(err);
        }
    })
})

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
                url: `${userUrl}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(user);
                }
            });
        }
    });
});
