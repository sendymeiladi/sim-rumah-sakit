const visits = $('.dataTable')
const visitsUrl = `${BASE_URL}/api/visit-treatment`
const modalTitle = $('.title')
const submitButton = $('#submit-button')

const formConfig = {
    fields: [
        {
            id: 'patient_id',
            name: 'Nama'
        },
        {
            id: 'visit_type',
            name: 'Jenis Kunjungan'
        },
        {
            id: 'visit_date',
            name: 'Waktu'
        },
        {
            id: 'treatment_id',
            name: 'Tindakan'
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
            {data: 'tindakan', name: 'tindakan'},
            {data: 'aksi', name: 'aksi'},
        ]
    });
}

$(function () {
    getInitData()
})

const resetForm = () => formConfig.fields.forEach(({id}) => $(`#${id}`).val(''))


submitButton.on('click', function () {
    const id = $('#id').val()
    $(this).text().toLowerCase() === "ubah" ? update(id) : store()
})

const update = id => {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const formData = dataForm();

    $.ajax({
        url: `${visitsUrl}/${id}`,
        method: 'PUT',
        dataType: 'json',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: res => {
            $('#addVisitTreatmentButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(visits);
        },
        error: ({responseJSON, status}) => {
            console.error('Error updating Tindakan:', responseJSON, status);
        }
    });
}

const dataForm = () => {
    return {
        treatment_id: $('#treatment').val(),
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

$(document).on('click', '.btn-treatment', function () {
    const visitId = $(this).data('id');
    $.ajax({
        url: `${visitsUrl}/${visitId}`,
        method: 'GET',
        dataType: 'json',
        success: res => {
            $('#id').val(res.id);
            submitButton.text('Ubah');
            modalTitle.text('Tambahkan Tindakan');

            $.each(res, function(key, value) {
                $(`#${key}`).val(value);
            });

            $('#name').val(res.patient_id );
            $('#visit_type').val(res.visit_type );
            $('#treatment').val(res.treatment_id);

            $('#addVisitTreatmentButton').modal('show');
        },
        error: err => {
            console.log(err);
        }
    })
})
