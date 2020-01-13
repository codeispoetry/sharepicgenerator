$('#download').click(function () {
    $(this).prop("disabled", true);
    let description = $(this).html();
    let secondsAtStart = 600;
    let secondsWaitingInterval;



    if(config.video){
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Das Video wird erstellt</span>');
        window.setTimeout(function() {
            $('#download').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> noch max. <span id="secondswaiting">' + secondsAtStart + '</span> Sekunden</span>');
            secondsWaitingInterval = window.setInterval(function () {
                $('#secondswaiting').html(secondsAtStart);
                secondsAtStart--;
            }, 1000);
        },2000);

    }else{
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Augenblick bitte');
    }




    $('#canvas').addClass('opacity');

    let format = 'jpg';

    if( config.video == 1 ){
        format = 'mp4';
        background.svg.hide();
    }

    let data = draw.svg();
   
    if( config.video == 1 ){
        background.svg.show();
    }
    

    $.ajax({
        type: "POST",
        url: 'createpic.php',
        data: {svg: data, format: format, videofile: config.videofile, width: $('#width').val()},
        success: function (data, textStatus, jqXHR) {
            let obj = JSON.parse(data);
            $('#download').prop("disabled", false);
            $('#canvas').removeClass('opacity');
            $('#download').html(description);
            window.clearInterval(secondsWaitingInterval);

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