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
                error: function (i) {
                    $('#go-login').html('SIGN IN');
                    const error = JSON.parse(i.responseText);
                    if (error.data !== null) {
                        $.each(error.data, function (i, j) {
                            $('#' + i).addClass('is-invalid');
                            login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + j + '</span>');
                        });
                    } else {
                        login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + error.message + '</span>');
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
        if (document.getElementsByName('password')[0].value !== document.getElementsByName('validate_password')[0].value) {
            pass_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Passwords do not match</span>');
        } else {
            const form = new FormData(document.getElementById('form-register'));
            const pass1 = form.get('password');
            const pass2 = form.get('validate_password');
            form.append('_token', `${_token}`);
            form.set('password', pass1);
            form.set('validate_password', pass2);
            form.set('agree_term', form.get('agree_terms') === 'on');

            $.ajax({
                url: 'sign-up',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status === 200) {
                        window.location.href = 'login';
                    } else {
                        pass_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + data.message + '</span>');
                    }
                },
                error: function (i) {
                    const error = JSON.parse(i.responseText);
                    if (error.data !== null) {
                        $.each(error.data, function (i, j) {
                            $('#' + i).addClass('is-invalid');
                            pass_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + j + '</span>');
                        });
                    } else {
                        pass_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + error.message + '</span>');
                    }
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
        if(src.length === 0) return;
        const url = src.attr('src').split('/');
        if (url[url.length - 1] !== image) {
            url[url.length - 1] = image;
            src.attr('src', url.join('/'));
        }
    }
})
