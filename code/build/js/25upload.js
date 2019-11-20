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

    background.filename = data.filename;

    $('#width').val(draw.width());
    $('#height').val(draw.height());

    calculateSizes();
    setDrawsize();

    background.draw();
    pin.draw();
    window.setTimeout(text.draw, 10);
}


function calculateSizes() {
    $('#textsize').attr('min', draw.width() * 0.2);
    $('#textsize').attr('max', draw.width());
    $('#textsize').val(draw.width() * 0.5);

    $('#textX').val(0);
    $('#textY').val(draw.height() / 2);

    $('#pinsize').attr('min', draw.width() * 0.1);
    $('#pinsize').attr('max', draw.width() * 0.25);
    $('#pinsize').val(draw.width() * .175);

    $('#pinX').val(draw.width() / 2);
    $('#pinY').val(draw.height() / 2);


    $('#backgroundsize').attr('min', draw.width());
    $('#backgroundsize').attr('max', draw.width() * 5);
    $('#backgroundsize').val(draw.width());

    $('#backgroundX').val(0);
    $('#backgroundY').val(0);
}

