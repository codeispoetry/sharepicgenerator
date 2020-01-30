$('#pinsize').bind('input propertychange', function () {
    pin.draw();
});

$('#pintofront').click( function () {
    pin.svg.front();
});


const pin = {
    isLoaded: false,

    svg: draw.rect(0,0),

    draw() {
        return false;
       
    },

    bounce: function () {
        return false;
        
    }
};