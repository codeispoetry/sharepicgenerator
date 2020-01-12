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
        //console.log("Fertig",e);

        let obj = JSON.parse(e.target.response);
        $('#' + id).prop('disabled', false);
        $('#waiting').removeClass('active');

       
        config.video = (obj.video == 1);
       

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

    
    let reader = new FileReader();
    reader.onload = function () {

        $.post("upload.php", {id: id, data: reader.result, user: config.user})
            .done(function (data) {

               
            });

    };
    //reader.readAsDataURL(input.files[0]);
   
});


function uploadImageByUrl(url, callback = function () {}) {

    $('#waiting').addClass('active');

    var request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.responseType = 'blob';
    request.onload = function () {
        let reader = new FileReader();
        reader.onload = function () {
            $.post("upload.php", {data: reader.result})
                .done(function (data) {
                    let obj = JSON.parse(data);
                    $('.overlay.active').removeClass('active');
                    afterUpload(obj);
                    callback();
                });

        };
        reader.readAsDataURL(request.response);
    };
    request.send();
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

