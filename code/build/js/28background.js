const background = {
    svg: draw.circle(0),
    isLoaded: false,

    draw() {
        this.svg.remove();

        let filename = $('#backgroundURL').val();

        this.svg = draw.image(filename, function (event) {
            this.back().draggable();
            background.isLoaded = true;
            background.resize();
            background.addFilter();

            background.svg.move(parseInt($('#backgroundX').val()), parseInt($('#backgroundY').val()));

            this.on('dragend.namespace', function (event) {
                $('#backgroundX').val(Math.round(this.x()));
                $('#backgroundY').val(Math.round(this.y()));
                background.uncoveredAreaWarning();
            });

            // no dragging when nothing to drag
            this.draggable().on('beforedrag', (e) => {
               if( background.svg.width() ==  draw.width() 
                    &&  background.svg.x() == 0 
                    && background.svg.height() ==  draw.height() 
                    && background.svg.y() == 0 
               ){
                    e.preventDefault();
               }
              })
        });


    },

    addFilter: function(){
        this.svg.filterWith(function (add) {
            add.colorMatrix('saturate', $('#graybackground').val() )
                .gaussianBlur( $('#blurbackground').val() );
        });
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

        if (background.hasRoundingError()){
            let size = parseInt($('#backgroundsize').val());
            $('#backgroundsize').val( size+=5);
            this.resize();
        }
        background.uncoveredAreaWarning();
    },

    hasRoundingError: function(){
        return (draw.height() - background.svg.height() > 0);
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


$('#graybackground, #blurbackground').bind('input propertychange', function () {
    background.addFilter();
});