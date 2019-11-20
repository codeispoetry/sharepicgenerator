$('#uploadfile').change(function (event) {
    $('#uploadfile').prop('disabled', true);
    $('#upload .message').html('Lade hoch...');
    let input = event.target;

    let reader = new FileReader();
    reader.onload = function () {

        $.post("upload.php", {data: reader.result})
            .done(function (data) {
                let obj = JSON.parse(data);
                $('#uploadfile').prop('disabled', false);
                $('#upload .message').html('');
                afterUpload(obj);
            });

    };
    reader.readAsDataURL(input.files[0]);

});


function uploadImageByUrl(url, callback = function () {
}) {

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
    info.previewWidth = draw.width()
    info.previewHeight = draw.height();

    background.filename = data.filename;

    $('#width').val(draw.width());
    $('#height').val(draw.height());

    setDrawsize();

    background.draw();
    pin.draw();
    window.setTimeout(text.draw, 10);
}


