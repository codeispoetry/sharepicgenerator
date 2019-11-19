var draw = SVG().addTo('#canvas').size(info.width,info.height)

var bgpic = {
    width: 800,
    height: 450,
    originalWidth: 1920,
    originalHeight: 1080,
    filename: 'assets/bg_small.jpg'
}

$( document ).ready(function() {
    afterUpload(bgpic);
    handleSubline();
});

function redraw(){
    $('#textfieldresize').attr('min', draw.width() / 6 );
    $('#textfieldresize').attr('max', draw.width());
    textfield.size(draw.width()/ 1.5).move(50,50);

    $('#pinresize').attr('min', draw.width() / 10 );
    $('#pinresize').attr('max', draw.width() / 4 );
    $('#pinresize').val( draw.width() / 7 );
    pin.move(draw.width() / 2, draw.height() / 2 );


    $('#logoresize').attr('min', draw.width() / 20 );
    $('#logoresize').attr('max', draw.width() / 5 );
    $('#logoresize').val(  draw.width() / 13 );

    image.back();
    setLogoPosition();
    handleSubline();
}

