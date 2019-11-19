var pin = draw.image('assets/pin.svg', function (event) {   
    pin.size(100).move( draw.width() / 2, draw.height() / 2);
    $('#pinresize').val( 100 );
    pin.addClass('draggable').draggable();
});


$('#pinresize').bind('input propertychange', function() {
    let val = parseInt( $(this).val() );
    pin.size( val );
})
