const background = {
    svg: draw.circle(0),
    isLoaded: false,

    draw() {
        this.svg.remove();

        $('#backgroundURL').val(this.filename);

        this.svg = draw.image(this.filename, function (event) {
            this.back().draggable();
            background.isLoaded = true;
            background.resize();
            background.svg.move(parseInt($('#backgroundX').val()), parseInt($('#backgroundY').val()));

            this.on('dragend.namespace', function (event) {
                $('#backgroundX').val(Math.round(this.x()));
                $('#backgroundY').val(Math.round(this.y()));
                background.uncoveredAreaWarning();
            });

        })
    },


    reset: function () {
        $('#backgroundX').val(0);
        $('#backgroundY').val(0);
        $('#backgroundsize').val(parseInt($('#backgroundsize').prop('min')));
        this.draw();
        background.uncoveredAreaWarning();
    },

    resize: function () {
        let val = parseInt($('#backgroundsize').val());
        this.svg.size(val);
        background.uncoveredAreaWarning();
    },

    uncoveredAreaWarning: function () {
        if (!this.isLoaded) return false;

        let error = false;

        switch($('#design').val()){
            case 'bigright':
                if (this.svg.x() > 0) error = true;
                if (this.svg.y() > 0) error = true;
                if (this.svg.y() + this.svg.height() < draw.height()) error = true;
            break;
            default:
                if (this.svg.x() > 0) error = true;
                if (this.svg.x() + this.svg.width() < draw.width()) error = true;
                if (this.svg.y() > 0) error = true;
                if (this.svg.y() + this.svg.height() < draw.height()) error = true;
        }
        

        if (error) {
            message("Im Bild entsteht ein weißer Rand. Platziere das Bild neu, <u class=\"cursor-pointer\" onClick=\"background.reset();\">setze es zurück</u> oder vergrößere es.");
        } else {
            message();
        }
    }
};


$('#backgroundreset').click(function () {
    background.reset();
});

$('#backgroundsize').bind('input propertychange', function () {
    background.resize();
});
