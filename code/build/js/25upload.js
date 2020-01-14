$('.upload-file').change(function (event) {
    let id = $(this).attr('id');
    let file = document.getElementById(id).files[0];
    let size = document.getElementById(id).files[0].size/1024/1024;
    let maxFileSize = 100; // in MB, note this in .htaccess as well
    if( size > 100 ){
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

    
    client.onerror = function(e) {
        console.log("onError",e);
    };
    
    client.onload = function(e) {
        let obj = JSON.parse(e.target.response);
        $('#' + id).prop('disabled', false);
        $('#waiting').removeClass('active');

        if(obj.error){
            alert(obj.error);
        }
       
        config.video = (obj.video == 1);
        config.videofile = obj.videofile;
        config.filename = obj.filename;
        config.videoduration = obj.videoduration;

        switch ( id ){
            case "uploadfile":
                afterUpload(obj);
                break;
            case "uploadlogo":
                $('#logoselect').val('custom');
                logo.load();
                break;
            default:
                console.log("error in upload");
        }

    };
    
    client.upload.onprogress = function(e) {
        let p = Math.round(100 / e.total * e.loaded);
        $('#uploadpercentage').html( p );
    };
    
    client.onabort = function(e) {
        console.log("Upload abgebrochen");
    };
    
    client.open("POST", "upload.php");
    client.send(formData);

});


function uploadImageByUrl(url, callback = function () {}) {

    $('#waiting').addClass('active');
    let id = 'uploadbyurl';

    let formData = new FormData();
    client = new XMLHttpRequest();
    formData.append("id", id);
    formData.append("url2copy", url);

    client.onerror = function(e) {
        console.log("onError",e);
    };

    client.onload = function(e) {
        let obj = JSON.parse(e.target.response);
        $('#waiting').removeClass('active');
        $('#pixabay').removeClass('active');

        if(obj.error){
            alert(obj.error);
        }

        config.filename = obj.filename;

        afterUpload(obj);
    };

    client.open("POST", "upload.php");
    client.send(formData);
}

function afterUpload(data) {
    draw.size(data.width, data.height);
    info.originalWidth = data.originalWidth;
    info.originalHeight = data.originalHeight;
    info.previewWidth = draw.width();
    info.previewHeight = draw.height();

    background.filename = data.filename;

    $('#width').val( data.originalWidth );
    $('#height').val( data.originalHeight );

    setDrawsize();

    background.draw();
    pin.draw();
    window.setTimeout(text.draw, 10);
}


$('.uploadfileclicker').click(function(){
    $('#uploadfile').click();
});

$('.uploadlogoclicker').click(function(){
    $('#uploadlogo').click();
});

