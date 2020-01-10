$('.size').bind('input propertychange', setDrawsize);
$('#sizereset').click(resetDrawsize);
$('#sizepresets').on('change', function () {
    let dimensions = this.value.split(':');
    setDimensions( ...dimensions );
    $(this).val($("#sizepresets option:first").val());
});

function setDrawsize() {
    let width = $('#width').val();
    let height = $('#height').val();
    let aspectratio = width / height;

    if (width > 800) {
        width = 800;
        height = width / aspectratio;
    }

    while( height > 800 ){
        width -= 50;
        height = width / aspectratio;
    }

    draw.size(width, height);

    $('#canvas').width(draw.width());
    $('#canvas').height(draw.height());

    calculateSizes();

    text.bounce();
    pin.bounce();
    window.setTimeout(logo.draw, 100);
}

function resetDrawsize() {
    $('#width').val(info.originalWidth);
    $('#height').val(info.originalHeight);
    setDrawsize();
}

function setDimensions(width, height) {
    $('#width').val(width);
    $('#height').val(height);
    setDrawsize();
}


function calculateSizes() {
    // here are also the default sizes after init 
    $('#textsize').attr('min', draw.width() * 0.1);
    $('#textsize').attr('max', draw.width());
    $('#textsize').val(draw.width() * 0.3);

    $('#textX').val(0);
    $('#textY').val(draw.height() / 5);

    $('#pinX').val(draw.width() * 0.7);
    $('#pinY').val(draw.height() * 0.5);

    $('#backgroundsize').attr('min', draw.width());
    $('#backgroundsize').attr('max', draw.width() * 5);
    $('#backgroundsize').val(draw.width());

    $('#backgroundX').val(0);
    $('#backgroundY').val(0);
}