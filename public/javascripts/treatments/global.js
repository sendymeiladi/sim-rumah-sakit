const treatments = $('.dataTable')
const treatmentsUrl = `${BASE_URL}/api/treatments`
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
            id: 'price',
            name: 'Harga'
        },
    ]
}


const getInitData = () => {
    treatments.DataTable({
        processing: true,
        serverSide: true,
        ajax: treatmentsUrl,
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
            {data: 'price', name: 'price'},
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
        modalTitle.text('Tambah Tindakan')
        submitButton.text('Tambah')
        resetForm()
        $('#addTreatmentsButton').modal('show');
    })

    $('#addTreatmentsButton').on('hidden.bs.modal', function () {
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
        url: treatmentsUrl,
        method: 'POST',
        dataType: 'json',
        data: dataForm(),
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addTreatmentsButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(treatments);
        },
        error: ({responseJSON}) => {
            handleError(responseJSON);
        }
    });
}

const update = id => {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: `${treatmentsUrl}/${id}`,
        method: 'PUT',
        dataType: 'json',
        data: dataForm(),
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addTreatmentsButton').modal('hide');
            resetForm()
            toastr.success(res.message, 'Success')
            reloadDatatable(treatments)
        },
        error: ({responseJSON}) => {
            handleError(responseJSON)
        }
    })
}

const dataForm = () => {
    return {
        name: $('#name').val(),
        price: $('#price').val(),
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
    const treatmentsId = $(this).data('id')
    $.ajax({
        url: `${treatmentsUrl}/${treatmentsId}`,
        method: 'GET',
        dataType: 'json',
        success: res => {
            $('#id').val(res.id)
            submitButton.text('Ubah')
            modalTitle.text('Ubah Tindakan')
            formConfig.fields.forEach(({id}) => {
                $(`#${id}`).val(res?.[id]);
            })
            $('#addTreatmentsButton').modal('show');
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
                url: `${treatmentsUrl}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(treatments);
                },
                error: err => {
                        toastr.error('Gagal menghapus data. Silahkan coba lagi.', 'Error');
                }
            });
        }
    });
});
