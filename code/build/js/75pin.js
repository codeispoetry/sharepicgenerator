var pin = draw.image('assets/pin.svg', function (event) {   
    pin.size( 100 ).move( draw.width() / 2, draw.height() / 2);
    pin.draggable();
});
