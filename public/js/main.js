$(document).ready(function () {
    $('form').submit(function (event) {
        var json;
        event.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                json = jQuery.parseJSON(result);
                if (json.status === 'error') {
                    $.each(json.fields, function (index, value) {
                        $('.form-group').find('#' + index).addClass('is-invalid');
                        $('.form-group').find('#' + index).parent().find('.invalid-feedback').html(value);
                    });
                } else if (json.success) {
                    window.location.href = '/' + json.url + '?success=' + json.success;
                } else {
                    window.location.href = '/' + json.url;
                }
            },
            error: function (data) {
                if (data.status === 403) {
                    window.location.href = '/login';
                }
            }
        });
    });

    $('.form-control').on('click', function () {
        $(this).removeClass('is-invalid');
        $(this).closest('.form-group').find('.invalid-feedback').html('');
    });

    $('.close').on('click', function () {
        window.history.pushState({}, document.title, "/");
    })
});

