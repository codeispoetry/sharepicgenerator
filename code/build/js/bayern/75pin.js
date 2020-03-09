$('#pinsize').bind('input propertychange', function () {
    pin.draw();
});

$('#pintofront').click( function () {
    pin.svg.front();
});


const pin = {
    isLoaded: false,

    svg: draw.circle(0),

    load( file = "pin.svg"){
        pin.svg.remove();
        pin.svg = draw.image('../bayern/' + file, function (event) {
            pin.isLoaded = true;
            pin.svg.on('dragend.namespace', function (event) {
                $('#pinX').val(Math.round(pin.svg.x()));
                $('#pinY').val(Math.round(pin.svg.y()));
                pin.bounce();
            });
            pin.draw();
        }).addClass('draggable').draggable();
    },

    draw() {
        if (!pin.isLoaded) return false;

        pin.svg.move(parseInt($('#pinX').val()), parseInt($('#pinY').val()));
        pin.svg.size(parseInt($('#pinsize').val()));
        pin.svg.front();
    },

    bounce: function () {
        if (!this.isLoaded ) return false;
        if (this.svg.x() < 15) {
            $('#pinX').val(15);
            this.draw();
        }
        if (this.svg.x() > draw.width() - this.svg.width() - 15) {
            $('#pinX').val(draw.width() - this.svg.width() - 15);
            this.draw();
        }
        if (this.svg.y() < 30) {
            $('#pinY').val(30);
            this.draw();
        }
        if (this.svg.y() > draw.height() - this.svg.height() - 30) {
            $('#pinY').val(draw.height() - this.svg.height() - 30);
            this.draw();
        }
    }
};

pin.load();