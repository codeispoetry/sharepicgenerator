$('#download').click(function () {
    $(this).prop("disabled", true);
    let description = $(this).html();
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Augenblick bitte');
    $('#canvas').addClass('opacity');

    let data = draw.svg();
    let format = 'png';

    $.ajax({
        type: "POST",
        url: 'createpic.php',
        data: {svg: data, format: format, width: $('#width').val() },
        success: function (data, textStatus, jqXHR) {
            let obj = JSON.parse(data);
            $('#download').prop("disabled", false);
            $('#canvas').removeClass('opacity');
            $('#download').html(description);

            window.location.href = 'download.php?file=' + obj.basename + '&format=' + format;
        }
    });
});