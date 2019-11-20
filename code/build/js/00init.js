var draw = SVG().addTo('#canvas');

var bgpic = {
    width: 800,
    height: 450,
    originalWidth: 1920,
    originalHeight: 1080,
    filename: 'assets/bg_small.jpg'
}

$(document).ready(function () {
    afterUpload(bgpic);
    redraw();
});

function redraw() {
    $('#textfieldresize').attr('min', draw.width() / 6);
    $('#textfieldresize').attr('max', draw.width());
    $('#textfieldresize').val(draw.width() / 1.5);
    textfield.size(draw.width() / 1.5).move(50, 50);

    $('#pinresize').attr('min', draw.width() / 10);
    $('#pinresize').attr('max', draw.width() / 4);
    $('#pinresize').val(draw.width() / 7);
    pin.move(draw.width() / 2, draw.height() / 2);

    $('#logoresize').attr('min', draw.width() / 20);
    $('#logoresize').attr('max', draw.width() / 5);
    $('#logoresize').val(draw.width() / 13);

    $('#backgroundresize').attr('min', draw.width());
    $('#backgroundresize').attr('max', draw.width() * 5);
    $('#backgroundresize').val(draw.width());

    $('#canvas').height(draw.height());
    image.back();
    setLogoPosition();
    handleSubline();
}


var image = draw.circle(0);
function afterUpload(data) {
    draw.size(data.width, data.height);
    info.originalWidth = data.originalWidth;
    info.originalHeight = data.originalHeight;

    image.remove();

    image = draw.image(data.filename, function (event) {
        image.size(draw.width(), draw.height());
        image.draggable();
        setSize(draw.width(), draw.height());
        redraw();
    })
}