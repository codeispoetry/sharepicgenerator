$('.size').bind('input propertychange', setDrawsize);
$('#sizereset').click( resetDrawsize );

function setDrawsize() {
    let width = $('#width').val();
    let height = $('#height').val();

    draw.size( width, height);

    $('#canvas').height(draw.height());

    calculateSizes();

    text.bounce();
    pin.bounce();
    subline.draw();
    window.setTimeout(logo.draw,100);
}

function resetDrawsize(){
    $('#width').val( info.previewWidth );
    $('#height').val( info.previewHeight );
    setDrawsize();
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