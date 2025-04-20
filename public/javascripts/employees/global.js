const employees = $('.dataTable')
const employeesUrl = `${BASE_URL}/api/employees`
const addButton = $('#buttonAdd')
const modalTitle = $('.title')
const submitButton = $('#submit-button')


const formConfig = {
    fields: [
        {
            id: 'nip',
            name: 'No NIP'
        },
        {
            id: 'name',
            name: 'Nama'
        },
        {
            id: 'position',
            name: 'Posisi'
        },
        {
            id: 'joined_date',
            name: 'Tanggal Masuk'
        },
        {
            id: 'phone',
            name: 'Telepon'
        },        {
            id: 'address',
            name: 'Alamat'
        },
    ]
}


const getInitData = () => {
    employees.DataTable({
        processing: true,
        serverSide: true,
        ajax: employeesUrl,
        order: [[0, 'desc']],
        columns: [
            {
                "orderable": true,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'nip', name: 'nip'},
            {data: 'name', name: 'name'},
            {data: 'position', name: 'position'},
            {data: 'joined_date', name: 'joined_date'},
            {data: 'phone', name: 'phone'},
            {data: 'address', name: 'address'},
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
        modalTitle.text('Tambah Karyawan')
        submitButton.text('Tambah')
        resetForm()
        $('#addEmployeesButton').modal('show');
    })

    $('#addEmployeesButton').on('hidden.bs.modal', function () {
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
        url: employeesUrl,
        method: 'POST',
        dataType: 'json',
        data: dataForm(),
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addEmployeesButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(employees);
        },
        error: ({responseJSON}) => {
            handleError(responseJSON);
        }
    });
}

const update = id => {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: `${employeesUrl}/${id}`,
        method: 'PUT',
        dataType: 'json',
        data: dataForm(),
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addEmployeesButton').modal('hide');
            resetForm()
            toastr.success(res.message, 'Success')
            reloadDatatable(employees)
        },
        error: ({responseJSON}) => {
            handleError(responseJSON)
        }
    })
}

const dataForm = () => {
    return {
        nip: $('#nip').val(),
        name: $('#name').val(),
        position: $('#position').val(),
        joined_date: $('#joined_date').val(),
        phone: $('#phone').val(),
        address: $('#address').val(),
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
    const employeesId = $(this).data('id')
    $.ajax({
        url: `${employeesUrl}/${employeesId}`,
        method: 'GET',
        dataType: 'json',
        success: res => {
            $('#id').val(res.id)
            submitButton.text('Ubah')
            modalTitle.text('Ubah Karyawan')
            formConfig.fields.forEach(({id}) => {
                $(`#${id}`).val(res?.[id]);
            })
            $('#addEmployeesButton').modal('show');
        },
        error: err => {
            console.log(err)
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
                url: `${employeesUrl}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(employees);
                },
                error: err => {
                        toastr.error('Gagal menghapus data. Silahkan coba lagi.', 'Error');
                }
            });
        }
    });
});
