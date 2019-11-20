$('.size').bind('input propertychange', setDrawsize);

function setDrawsize() {
    let width = $('#width').val();
    let height = $('#height').val();

    draw.size( width, height);

    $('#canvas').height(draw.height());

    logo.draw();
    subline.draw();
}