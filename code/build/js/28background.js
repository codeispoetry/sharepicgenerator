const background = {
    svg: draw.circle(0),
    isLoaded: false,

    draw() {
        this.svg.remove();
        this.svg = draw.image(this.filename, function (event) {
            this.back().draggable();
            background.isLoaded = true;
            background.resize();
            background.svg.move(parseInt($('#backgroundX').val()), parseInt($('#backgroundY').val()));

            this.on('dragend.namespace', function (event) {
                $('#backgroundX').val(this.x());
                $('#backgroundY').val(this.y());
                background.bounceWarning();
            });

        })
    },


    reset: function () {
        $('#backgroundX').val(0);
        $('#backgroundY').val(0);
        $('#backgroundsize').val(parseInt($('#backgroundsize').prop('min')));
        this.draw();
        background.bounceWarning();
    },

    resize: function () {
        let val = parseInt($('#backgroundsize').val());
        this.svg.size(val);
        background.bounceWarning();
    },

    bounceWarning: function () {
        if (!this.isLoaded) return false;

        let error = false;
        if (this.svg.x() > 0) error = true;
        if (this.svg.x() + this.svg.width() < draw.width()) error = true;
        if (this.svg.y() > 0) error = true;
        if (this.svg.y() + this.svg.height() < draw.height()) error = true;

        if (error)
            message("Im Bild entsteht ein weißer Rand. Platziere das Bild neu, <a href=\"#\" onClick=\"background.reset();\">setze es zurück</a> oder vergrößere es.")
        else
            message();
    }

};


$('#backgroundreset').click(function () {
    background.reset();
});

$('#backgroundsize').bind('input propertychange', function () {
    background.resize();
});
