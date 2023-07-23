$(window.document).on('click', '.btn-action', function (e) {
    e.preventDefault();
    let id = $(this).data('id') ?? null; // Get id from data-id attribute
    let url = $(this).data('url') ?? window.location.href; // Get url from data-url attribute or current url
    let action = $(this).data('action') ?? ''; // Get action from data-action attribute
    let title = $(this).data('title') ?? null; // Get title from data-title attribute
    let modalId = $(this).data('modalId') ?? 'modal-master'; // Get modalId from data-modal-id attribute
    let bgClass = $(this).data('bgClass') ?? 'bg-default'; // Get bgClass from data-bg-class attribute

    if (action === 'create') {
        url = `${url}/create`;
    } else if (action === 'edit') {
        url = `${url}/${id}/edit`;
    } else if (action === 'delete') {
        url = `${url}/delete/${id}`;
    } else if (action === 'show') {
        url = `${url}/${id}`;
    }

    $.loadModal({
        url: url,
        id: `${modalId}`,
        dlgClass: 'fade',
        bgClass: `${bgClass}`,
        title: `${title}`,
        width: 'whatever',
        modal: {keyboard: false, backdrop: 'static'},
        ajax: {
            dataType: 'html',
            method: 'GET',
            cache: false,
            beforeSend: function () {
                $.showLoading();
            },
            success: function () {
                $.hideLoading();
                $(`#${modalId}`).modal('show');
            },
            error: function (xhr) {
                $.hideLoading();
                $.showError(xhr.status + ' ' + xhr.statusText);
            }
        },
    });
});

$(window.document).on('click', '.submit-data', function (e) {
    e.preventDefault()
    let btnSubmit = $(this);
    let textBtn = btnSubmit.text();
    let parent = $(this).parents('.modal').length ? $(this).parents('.modal') : $(this).parents();
    let formId = parent.find('form').attr('id');
    let progress = $('.progress-bar');
    let dismiss = parent.find('[data-bs-dismiss]');

    $(`#${formId}`).ajaxForm({
        dataType: 'json',
        uploadProgress: function (event, position, total, percentComplete) {
            let percentVal = percentComplete + '%';
            progress.width(percentVal);
            if (percentComplete === 100) {
                progress.html('Mohon tunggu...');
            } else {
                progress.html(percentVal);
            }
        },
        beforeSubmit: function () {
            progress.width('0%');
            progress.html('0% Complete');
            dismiss.attr('disabled', true);
            $('.progress').show();
            $('.form-control').removeClass('is-invalid border border-danger');
            $('.invalid-feedback, .alert-danger').remove();
            btnSubmit.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
        },
        success: function (response, status, xhr, $form) {
            $('.progress').hide();
            btnSubmit.attr('disabled', false).html('<i class="fa fa-save"></i> ' + textBtn);
            dismiss.removeAttr('disabled');
            if (response.status === true) {
                const _targetTable = $form.find('input[name="table-id"]').val() ?? null;
                const _targetFunction = $form.find('input[name="function"]').val() ?? null;
                const _redirect = $form.find('input[name="redirect"]').val() ?? null;

                swal({
                    title: response.title ?? "Good job!",
                    text: response.message,
                    icon: "success",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });

                if (_targetTable !== null) {
                    let tables = _targetTable.split(',');
                    $.each(tables, function (index, value) {
                        $(`#${value}`).DataTable().ajax.reload();
                    });
                }
                if (_targetFunction !== null) {
                    let functions = _targetFunction.split(',');
                    $.each(functions, function (index, value) {
                        window.eval?.(value) // Call target function
                    });
                }
                if (_redirect !== null) {
                    window.location.href = _redirect ?? ''; // Redirect to url
                }
                $('.modal').modal('hide'); // Hide modal
            } else {
                if (response.hasOwnProperty('errors')) {
                    _errorBuilder(response.data);
                } else {
                    swal({
                        title: response.title ?? "Oops!",
                        text: response.message,
                        icon: "error",
                        type: "error",
                        timer: 2500,
                        showConfirmButton: false
                    });
                }
            }
        },
        error: function (xhr) {
            if(xhr.status === 422) {
                _errorBuilder(xhr.responseJSON.errors);
            }else{
                swal({
                    title: "Oops!",
                    text: xhr.status + ' ' + xhr.statusText,
                    icon: "error",
                    type: "error",
                    timer: 2500,
                    showConfirmButton: false
                });
            }
            $('.progress').hide();
            btnSubmit.attr('disabled', false).html('<i class="fa fa-save"></i> ' + textBtn);
            dismiss.removeAttr('disabled');
            $('.message').html(`<div class="alert alert-danger fade show mt-3"><b>Error!</b> ${xhr.status} ${xhr.responseJSON.message}.</div>`)
        }
    }).submit();

    const _errorBuilder = function (errors) {
        $.each(errors, function (index, value) {
            $(`#${index}`).addClass('is-invalid border border-danger').parent().append(`<span class="invalid-feedback" role="alert"><strong>${value}</strong></span>`);
        });
    }
});
