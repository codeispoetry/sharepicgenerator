$('#download').click(function () {
    $(this).prop("disabled", true);
    let description = $(this).html();
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Augenblick bitte');
    $('#canvas').addClass('opacity');

    let data = draw.svg();
    let format = 'jpg';

    $.ajax({
        type: "POST",
        url: 'createpic.php',
        data: {svg: data, format: format, width: $('#width').val()},
        success: function (data, textStatus, jqXHR) {
            let obj = JSON.parse(data);
            $('#download').prop("disabled", false);
            $('#canvas').removeClass('opacity');
            $('#download').html(description);

            let downloadname = $('#text').val().toLowerCase();
            downloadname = downloadname.replace(/[ä|ö|ü|ß]/g, function (match) {
                switch (match) {
                    case 'ä':
                        return 'ae';
                    case 'ö':
                        return 'oe';
                    case 'ü':
                        return 'ue';
                    case 'ß':
                        return 'ss';
                }
            });
            downloadname = downloadname.replace(/[^a-zA-Z0-9]/g, '-');
            downloadname = downloadname.replace(/\-+/g, '-');
            downloadname = downloadname.replace(/^\-/g, '');
            downloadname = downloadname.replace(/\-$/g, '');

            window.location.href = 'download.php?file=' + obj.basename + '&format=' + format + '&downloadname=' + downloadname;
        }
    });
});