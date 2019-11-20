$('.size').bind('input propertychange', handleSize);

function handleSize() {
    let width = $('#width').val();
    let height = $('#height').val();

    draw.height(height);
    draw.width(width);
    redraw();
}

function setSize(width, height) {
    $('#width').val(width);
    $('#height').val(height);
}

$('#resetBackground').click(function () {
    image.move(0, 0).size(draw.width());
});

$('#backgroundresize').bind('input propertychange', function () {
    let val = parseInt($(this).val());
    image.size(val);
})
