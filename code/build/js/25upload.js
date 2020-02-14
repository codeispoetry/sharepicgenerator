$('.upload-file').change(function (event) {
    let id = $(this).attr('id');
    let file = document.getElementById(id).files[0];
    let size = document.getElementById(id).files[0].size/1024/1024;
    let maxFileSize = 100; // in MB, note this in .htaccess as well
    if( size > maxFileSize ){
        alert("Die Datei ist zu groß. Es sind maximal " + maxFileSize + " MB erlaubt.\n\nSchicke Dir die Datei per z.B. WhatsApp zu, dann wird sie automatisch verkleinert. Mehr als 20 MB pro Minute Video braucht es nicht.");
        return false;
    }

    $('#waiting').addClass('active');
    $(this).prop('disabled', true);

    let formData = new FormData();
    client = new XMLHttpRequest();
    
    if(!file)
        return;

    formData.append("file", file);
    formData.append("id", id);
    formData.append("user", config.user);
    formData.append("accesstoken", config.accesstoken);

    
    client.onerror = function(e) {
        console.log("onError",e);
    };
    
    client.onload = function(e) {
        let obj = JSON.parse(e.target.response);
        $('#' + id).prop('disabled', false);
        $('#waiting').removeClass('active');

        if(obj.error){
            console.log(obj.error);
            return false;
        }
       
        config.video = (obj.video == 1);
        if(obj.video == 1){
            config.videofile = obj.videofile;
            config.filename = obj.filename;
            config.videoduration = obj.videoduration;
            $('#width').val( obj.originalWidth );
            $('#height').val( obj.originalHeight );
        }


        redrawCockpit();

        switch ( id ){
            case "uploadfile":
                afterUpload(obj);
                break;
            case "uploadlogo":
                $('#logoselect').val('custom');
                logo.load();
                break;
            case "uploadicon":
                $('#iconfile').val(obj.iconfile);
                icon.load();
                $('.iconsizeselectwrapper').removeClass('d-none');
                break;
            default:
                console.log("error in upload", obj);
        }

    };
    
    client.upload.onprogress = function(e) {
        let p = Math.round(100 / e.total * e.loaded);
        $('#uploadpercentage').html( p );
    };
    
    client.onabort = function(e) {
        console.log("Upload abgebrochen");
    };
    
    client.open("POST", "../upload.php");
    client.send(formData);

});


function uploadFileByUrl(url, callback = function () {}) {

    $('#waiting').addClass('active');
    let id = 'uploadbyurl';

    let formData = new FormData();
    client = new XMLHttpRequest();
    formData.append("id", id);
    formData.append("url2copy", url);

    client.onerror = function(e) {
        console.log("onError",e);
    };

    client.upload.onprogress = function(e) {
        let p = Math.round(100 / e.total * e.loaded);
        $('#uploadpercentage').html( p );

        if( p > 99 ){
            $('#uploadstatus').html( 'Dein Bild wird verarbeitet...' );
        }
    };

    client.onload = function(e) {
        let obj = JSON.parse(e.target.response);

        closeOverlay();

        if(obj.error){
            console.log(obj);
        }

        config.filename = obj.filename;
        config.video = (obj.video == 1);
        if( obj.video == 1 ){
            
            config.videofile = obj.videofile;
            config.filename = obj.filename;
            config.videoduration = obj.videoduration;

            $('#width').val( obj.originalWidth );
            $('#height').val( obj.originalHeight );
        }

        redrawCockpit();

        afterUpload(obj);
        callback();
    };

    client.open("POST", "../upload.php");
    client.send(formData);
}

function afterUpload(data) {
    draw.size(data.width, data.height);
    info.originalWidth = data.originalWidth;
    info.originalHeight = data.originalHeight;
    info.previewWidth = draw.width();
    info.previewHeight = draw.height();

    $('#backgroundURL').val(data.filename);


    //$('#width').val( data.originalWidth );
    //$('#height').val( data.originalHeight );

    $('#fullBackgroundName').val( data.fullBackgroundName );
    setDrawsize();

    background.draw();
    //pin.draw();
    //window.setTimeout(text.draw, 10);
}


$('.uploadfileclicker').click(function(){
    $('#uploadfile').click();
});

$('.uploadlogoclicker').click(function(){
    $('#uploadlogo').click();
});

$('.uploadiconclicker').click(function(){
    $('#uploadicon').click();
});

