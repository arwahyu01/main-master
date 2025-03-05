/*jshint esversion: 11 */

// Show small notification
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle="push-menu"]').forEach(function (element) {
        element.addEventListener('click', function () {
            if (document.body.classList.contains('sidebar-collapse')) {
                localStorage.setItem('sidebar', 'false');
                $('.small-notify').addClass('hide');
            } else {
                localStorage.setItem('sidebar', 'true');
                $('.small-notify').removeClass('hide');
            }
        });
    });

    if (localStorage.getItem('sidebar') === 'true') {
        document.body.classList.add('sidebar-collapse');
        $('.small-notify').addClass('hide');
    } else {
        document.body.classList.remove('sidebar-collapse');
        $('.small-notify').removeClass('hide');
    }
});

// Function to format rupiah
const formatRupiah = (number, prefix = 'Rp. ') => {
    const numberString = number.toString().replace(/[^0-9]/g, '');
    const split = numberString.split(',');
    const rupiah = split[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    const result = split[1] ? `${rupiah},${split[1]}` : rupiah;
    return prefix + result;
};
// End Function to format rupiah

$(function () {
    // negative block
    $(document).on('input', '.negative-block', function (e) {
        if (e.keyCode === 109 || e.keyCode === 189) e.preventDefault();
        if ($(this).val() < 0) $(this).val(0);
    });
    // end negative block

    //remove all whitespace
    $(document).on('input', '.remove-whitespace', function () {
        $(this).val($(this).val().replace(/\s/g, ''));
    });
    $(document).on('change', '.remove-whitespace', function () {
        $(this).val($(this).val().replace(/\s/g, ''));
    });
    // end remove all whitespace

    // remove whitespace on first and last
    $(document).on('input', '.remove-whitespace-first-last', function () {
        $(this).val($(this).val().replace(/^\s+/, '').replace(/\s+$/, ''));
    });
    $(document).on('change', '.remove-whitespace-first-last', function () {
        $(this).val($(this).val().replace(/^\s+/, '').replace(/\s+$/, ''));
    });
    // end remove whitespace on first and last

    //regex only number
    $(document).on('input', '.only-number', function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
    $(document).on('change', '.only-number', function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
    // end regex only number

    //regex only alphabet
    $(document).on('input', '.only-alphabet', function () {
        $(this).val($(this).val().replace(/[^a-zA-Z]/g, ''));
    });
    $(document).on('change', '.only-alphabet', function () {
        $(this).val($(this).val().replace(/[^a-zA-Z]/g, ''));
    });
    // end regex only alphabet

    // format rupiah
    $(document).on('input', '.format-rupiah', function () {
        $(this).val(formatRupiah($(this).val(), 'Rp. '));
    });
    $(document).on('change', '.format-rupiah', function () {
        $(this).val(formatRupiah($(this).val(), 'Rp. '));
    });
    // end format rupiah

    // Input File Validation
    $(document).on('change', 'input[type="file"]', function () {
        clearError();
        let id = $(this).attr('id');q
        let size = $(this).data('size') || 0;
        let max_byte = size * 1024;
        if(!$(this).attr('accept')) return;
        const accept = $(this).attr('accept').split(',').map(item => item.trim());
        const fileInput = $(this)[0];

        $.each(fileInput.files, function (index, value) {
            if (value) {
                if (size !== 0 && value.size > max_byte) {
                    errorBuilder({[id]: `File ${value.name} melebihi batas maksimal ${size / 1024} MB`});
                    fileInput.value = '';
                    return false;
                }

                let fileType = value.type.split('/');
                let check = false;

                accept.forEach(function (item) {
                    if (item.endsWith("/*")) {
                        let mainType = item.split('/')[0];
                        if (fileType[0] === mainType || mainType === '*') {
                            check = true;
                        }
                    } else {
                        let ty = item.split('/');
                        if (ty.length === 2 && ty[0] === fileType[0] && (ty[1] === fileType[1] || ty[1] === '*')) {
                            check = true;
                        }
                    }
                });

                if (!check) {
                    errorBuilder({[id]: `File ${value.name} tidak sesuai dengan tipe file yang diizinkan`});
                    fileInput.value = '';
                    return false;
                }
            }
        });
    });
    // End Input File Validation

    //sort_text
    $('.sort_text').html(function () {
        let text = $(this).text();
        let text_sort = text.substring(0, 20);
        if (text.length > 20) {
            $(this).html('<i class="ti-user text-muted me-2"></i> ' + text_sort + '...');
        }
    });
    //end sort_text
});

