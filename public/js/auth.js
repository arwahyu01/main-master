/*jshint esversion: 11 */
$(function () {
    const _token = $('meta[name="csrf-token"]').attr('content');

    $(document).keypress(function (e) {
        if (e.key === 'Enter') $('#go-login').click();
    });

    $('#go-login').on('click', function () {
        const password = window.document.getElementsByName('password')[0];
        const email = window.document.getElementsByName('email')[0];
        const login_info = $('.info-login');
        if (password.value !== '' && email.value !== '') {
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            $('.form-control').removeClass('is-invalid');
            const form = new FormData(document.getElementById('login-form'));
            form.append('_token', `${_token}`);
            form.append('device_name', "web");
            form.set('password', form.get('password'));
            form.set('remember', form.get('remember') === 'on');
            $.ajax({
                url: 'sign-in',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    login_info.html('');
                },
                success: function (e) {
                    $('#go-login').html('SIGN IN');
                    if (e.status === 200) {
                        login_info.html('<i class="fa fa-check text-success"></i> Login successful, redirecting...');
                        window.location.href = 'login';
                    } else {
                        login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + e.message + '</span>');
                    }
                },
                error: function (xhr) {
                    $('#go-login').html('SIGN IN');

                    if (xhr.status === 422) { // Validasi gagal
                        const errors = xhr.responseJSON?.errors; // Akses pesan validasi
                        let errorMessages = '';

                        // Tandai field yang bermasalah dan kumpulkan pesan kesalahan
                        for (const field in errors) {
                            if (Object.hasOwnProperty.call(errors, field)) {
                                const messages = errors[field];
                                errorMessages += messages.join('<br>'); // Gabungkan pesan kesalahan
                                $(`[name="${field}"]`).addClass('is-invalid'); // Tambahkan kelas untuk menandai input
                            }
                        }

                        login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + errorMessages + '</span>');
                    } else if (xhr.status === 401) { // Autentikasi gagal
                        const message = xhr.responseJSON?.message || 'Akses tidak sah, silakan periksa kredensial Anda.';
                        login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + message + '</span>');
                    } else {
                        // Tangani kesalahan lainnya
                        login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> An unexpected error occurred</span>');
                    }
                }
            });
        } else {
            if (password.value === '') {
                password.classList.add('is-invalid');
            }
            if (email.value === '') {
                email.classList.add('is-invalid');
            }
            login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Please fill in the form</span>');
        }
    });

    $('#register-me').on('click', function () {
        const pass_info = $('.pass-info');
        pass_info.html('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        if (document.getElementsByName('password')[0].value !== document.getElementsByName('validate_password')[0].value) {
            pass_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Passwords do not match</span>');
        } else {
            const form = new FormData(document.getElementById('form-register'));
            const pass1 = form.get('password');
            const pass2 = form.get('validate_password');
            form.append('_token', `${_token}`);
            form.set('password', pass1);
            form.set('validate_password', pass2);
            form.set('agree_terms', form.get('agree_terms') === 'on');

            $.ajax({
                url: 'sign-up',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#register-me').html('<i class="fa fa-spinner fa-spin"></i> Registering...');
                },
                success: function (data) {
                    pass_info.html('<i class="fa fa-check text-success"></i> Register successful, redirecting...');
                    setTimeout(() => window.location.href = 'email/verify', 2000);
                },
                error: function (e, i, j) {
                    setTimeout(() => {
                        $('#register-me').html('SIGN UP');
                        const error = JSON.parse(e.responseText);
                        if (error.errors) {
                            $.each(error.errors, function (i, j) {
                                $('#' + i).addClass('is-invalid').parent().append('<span class="invalid-feedback" role="alert"><b>' + j + '</b></span>');
                            });
                        } else {
                            pass_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + error.message + '</span>');
                        }
                    }, 200)
                }
            });
        }
    });

    let email_input = $('#email');
    let password_input = $('#password');
    let form_login = $('#login-form');
    email_input.on('focus', () => headerIconChanger('looking.png'));
    password_input.on('focus', () => headerIconChanger('close.png'));
    form_login.on('mouseover', () => headerIconChanger('standby.png'));

    $('.show-hide-password').on('click', function () {
        const input = $(this).parent().find('input');
        const icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
            headerIconChanger('peeking.png')
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
            headerIconChanger('close.png')
        }
    })

    const headerIconChanger = (image) => {
        const src = $('#header-image-vector');
        if (src.length === 0) return;
        const url = src.attr('src').split('/');
        if (url[url.length - 1] !== image) {
            url[url.length - 1] = image;
            src.attr('src', url.join('/'));
        }
    }

    //request-demo
    $('#request-demo').on('click', function () {
        let btnRequest = $(this);
        let btnText = btnRequest.html();
        $('.form-group').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        const form = new FormData(document.getElementById('requestDemoForm'));

        if (form.get('whatsapp') === '') {
            $('#whatsapp').addClass('is-invalid').parent().append('<span class="invalid-feedback" role="alert"><b>Whatsapp number is required</b></span>');
            return;
        }else{
            const regex = /^[0-9]{10,15}$/;
            if (!regex.test(form.get('whatsapp'))) {
                $('#whatsapp').addClass('is-invalid').parent().append('<span class="invalid-feedback" role="alert"><b>Invalid whatsapp number</b></span>');
                return;
            }
        }

        form.append('_token', `${_token}`);
        $.ajax({
            url: 'demo-request',
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            beforeSend: function () {
                btnRequest.html('<i class="fa fa-spinner fa-spin"></i> Sending request...');
            },
            success: function (data) {
                btnRequest.html('<i class="fa fa-check text-success"></i> Request sent successfully');
                setTimeout(() => window.location.href = '/login', 2000);
            },
            error: function (e, i, j) {
                btnRequest.html(btnText);
                const error = JSON.parse(e.responseText);
                if (error.errors) {
                    $.each(error.errors, function (i, j) {
                        $('#' + i).addClass('is-invalid').parent().append('<span class="invalid-feedback" role="alert"><b>' + j + '</b></span>');
                    });
                } else {
                    btnRequest.html('<i class="fa fa-exclamation-triangle"></i> ' + error.message);
                }
            }
        });
    });
})
