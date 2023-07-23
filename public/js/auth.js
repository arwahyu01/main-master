$(function () {
    const _token = $('meta[name="csrf-token"]').attr('content');

    $(document).keyup(function (e) {
        if (e.keyCode === 13) {
            $('#go-login').click();
        }
    });

    $('#go-login').on('click', function () {
        const password = window.document.getElementsByName('password')[0];
        const email = window.document.getElementsByName('email')[0];
        const login_info = $('.info-login');
        if (password.value !== '' && email.value !== '') {
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            $('.form-control').removeClass('is-invalid');
            let form = new FormData(document.getElementById('login-form'));
            form.append('_token', `${_token}`);
            form.append('device_name', "web");
            form.set('password', btoa(form.get('password')));
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
                    if (e.status === 200 && e.data !== null) {
                        if(e.data.hasOwnProperty('token')) {
                            login_info.html('<i class="fa fa-check text-success"></i> Login successful, redirecting...');
                            window.location.href = 'login';
                        }
                    } else {
                        login_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + e.message + '</span>');
                    }
                },
                error: function (i) {
                    $('#go-login').html('SIGN IN');
                    let error = JSON.parse(i.responseText);
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
        let pass_info = $('.pass-info');
        if (document.getElementsByName('password')[0].value !== document.getElementsByName('validate_password')[0].value) {
            pass_info.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Passwords do not match</span>');
        } else {
            let form = new FormData(document.getElementById('form-register'));
            let pass1 = btoa(form.get('password'));
            let pass2 = btoa(form.get('validate_password'));
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
                    let error = JSON.parse(i.responseText);
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
})
