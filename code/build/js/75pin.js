$('#pinsize').bind('input propertychange', function () {
    pin.draw();
});


const pin = {
    isLoaded: false,

    svg: draw.image('assets/pin.svg', function (event) {
        pin.isLoaded = true;
        this.on('dragend.namespace', function (event) {
            $('#pinX').val(Math.round(this.x()));
            $('#pinY').val(Math.round(this.y()));
            pin.bounce();
        });
        pin.draw();
    }).addClass('draggable').draggable(),

    draw() {
        if (!this.isLoaded) return false;

        pin.svg.move(parseInt($('#pinX').val()), parseInt($('#pinY').val()));
        pin.svg.size(parseInt($('#pinsize').val()));
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



