$('#pinsize').bind('input propertychange', function () {
    pin.draw();
});


const pin = {
    isLoaded: false,

    svg: draw.image('assets/pin.svg', function (event) {
        pin.isLoaded = true;
        this.on('dragend.namespace', function (event) {
            $('#pinX').val( this.x());
            $('#pinY').val( this.y());
        });
        pin.draw();
    }).addClass('draggable').draggable(),

    draw() {
        if (!this.isLoaded) return false;
        this.svg.move( parseInt($('#pinX').val()), parseInt($('#pinY').val( )));
        this.svg.size( parseInt($('#pinsize').val()));
    },

};

