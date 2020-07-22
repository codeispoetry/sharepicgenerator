$('#download,.download').click(function () {
    $(this).prop("disabled", true);

    config.toCloud = $(this).data('cloud');

    let description = $(this).html();
    let secondsWaitingInterval;

    if(config.video){
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Das Video wird erstellt ...</span>');
        window.setTimeout(function() {
            secondsWaitingInterval = window.setInterval(function () {
                getEncodingStatus();
            }, 3000);
        },3000);

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
        url: '../createpic.php',
        data: {svg: data, format: format, quality: config.quality, usepixabay: config.usePixabay, ismosaic: config.isMosaic, socialmediaplatform: config.socialmediaplatform,videofile: config.videofile, width: $('#width').val()},
        success: function (data, textStatus, jqXHR) {
            let obj = JSON.parse(data);
            $('.download').prop("disabled", false);
            $('#canvas').removeClass('opacity');
            $('.download').html(description);
            window.clearInterval(secondsWaitingInterval);

            let downloadname = getDownloadName();

            if( config.socialmediaplatform ){
                downloadname = downloadname.substring(0, 14) + '-' + config.socialmediaplatform.toLowerCase();
            }

            if(config.isMosaic){
                format = "zip";
            }

            if( config.toCloud ){
                $('.download').html('speichere Sharepic in der Cloud ... ');
                $.ajax({
                    type: "POST",
                    url: '../nextcloudsend.php',
                    data: {
                        file: obj.basename + 'jpg',
                        user: config.user,
                        accesstoken: config.accesstoken,
                        downloadname: downloadname + '.jpg'
                    },
                    success: function (data, textStatus, jqXHR) {

                        $('.download').html('speichere Arbeitsdatei in der Cloud ... ');
                        let obj = JSON.parse(data);

                        $.ajax({
                            type: "POST",
                            url: '../savework.php',
                            data: {data: $('#pic').serialize()},
                            success: function (data, textStatus, jqXHR) {
                                let obj = JSON.parse(data);
                                $.ajax({
                                        type: "POST",
                                        url: '../nextcloudsend.php',
                                        data: {
                                            file: obj.basename + '.zip',
                                            user: config.user,
                                            accesstoken: config.accesstoken,
                                            downloadname: downloadname + '.zip'
                                        },
                                        success: function (data, textStatus, jqXHR) {
                                            $('.download').html(description);
                                        }
                                    }
                                );

                            }
                        });

                    }
                });

                let data = $('#pic').serialize();




            }else {
                window.location.href = '../download.php?file=' + obj.basename + '&format=' + format + '&downloadname=' + downloadname;
            }
        }
    });
});



function getDownloadName(){
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

    downloadname = downloadname.substring(0, 30);

    return downloadname;
}

function getEncodingStatus(){
    $.ajax({
        url:"../getvideoencodestatus.php?videofile=" + config.videofile,
        type: 'GET',
        dataType: 'JSON',
        success : function(data){
            let percentage = Math.round(100 * data.currentposition / config.videoduration);

            $('#download').html( percentage + "% des Videos sind schon fertig. Bitte warten.");
        }
    });
}

