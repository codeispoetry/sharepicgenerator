$('#pinsize').bind('input propertychange', function () {
    pin.draw();
});

$('#pintofront').click(function () {
    pin.svg.front();
});


const pin = {
    isLoaded: false,

    svg: draw.text(''),


    draw() {

        pin.svg.remove();
        pin.svg = draw.group().addClass('draggable').draggable();

        // background
        let pintext = draw.text($('#pintext').val()).font(text.fontoutsidelines).fill('#ffffff').dy(1);

        // text
        let pinbackground = draw.rect(pintext.length() + 40, 8).fill("#e6007e");

        // and in reverse order
        pin.svg.add(pinbackground);
        pin.svg.add(pintext);

        pin.svg.move(parseInt($('#pinX').val()), parseInt($('#pinY').val()));
        pin.svg.size(parseInt($('#pinsize').val()));

        pin.svg.front();
    },

    bounce: function () {
        if (!this.isLoaded) return false;
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



$('#pintext').bind('input propertychange', pin.draw);
