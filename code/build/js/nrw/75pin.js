$('#pinsize').bind('input propertychange', function () {
    pin.draw();
});


const pin = {
    isLoaded: false,

    svg: draw.circle(0),

    load( file = "../assets/nrw/claim.svg"){
        pin.svg.remove();
        pin.svg = draw.image( file, function (event) {
            pin.isLoaded = true;

            pin.draw();
        })
    },

    draw() {
        if (!pin.isLoaded) return false;

        pin.svg.size( draw.width() * 0.33 ).move( 0, draw.height() - pin.svg.height() - 10 );
        pin.svg.front();
    },

    bounce(){
        // leave here for legacy reasons
    }


};

pin.load();