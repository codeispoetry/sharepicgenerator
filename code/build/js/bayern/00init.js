$(document).ready(function () {
    $('#text').val("!Leben\nlassen");

});

function reset(){
    // do nothing, stay here

    $('#textsize').attr('min', draw.width() * 0.2);
    $('#textsize').attr('max', draw.width());
    $('#textsize').val(draw.width() * 0.5);

    $('#textX').val(0);
    $('#textY').val(draw.height() / 2.4);

    $('#pinsize').attr('min', Math.max(50, draw.width() * 0.1));
    $('#pinsize').attr('max', Math.max(50, draw.width() * 0.25));
    $('#pinsize').val(draw.width() * .175);
}

