$('.upload-file').change(function (event) {

    $('#waiting').addClass('active');
    $(this).prop('disabled', true);

    let id = $(this).attr('id');

    let file = document.getElementById(id).files[0];
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
        console.log(e.target.response);

        let obj = JSON.parse(e.target.response);
        $('#' + id).prop('disabled', false);
        $('#waiting').removeClass('active');

        if(obj.error){
            alert(obj.error);
        }
       
        config.video = (obj.video == 1);
        config.videofile = obj.videofile;
        config.filename = obj.filename;


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
        console.log(e.target.response);

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

