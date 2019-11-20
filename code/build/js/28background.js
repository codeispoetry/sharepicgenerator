const background= {
    svg: draw.circle(0),

    draw(){
        this.svg.remove();
        this.svg = draw.image( this.filename, function (event) {
            this.back().draggable();
            background.resize();

            this.on('dragend.namespace', function (event) {
                $('#backgroundX').val( this.x());
                $('#backgroundY').val( this.y());
            });

        })
    },


    reset: function(){
        $('#backgroundX').val( 0 );
        $('#backgroundY').val( 0 );
        $('#backgroundsize').val( parseInt( $('#backgroundsize').prop('min')));
        this.draw();
    },

    resize: function(){
        let val = parseInt($('#backgroundsize').val());
        this.svg.size(val);
    }

};




$('#backgroundreset').click(function () {
    background.reset();
});

$('#backgroundsize').bind('input propertychange', function () {
    background.resize();
});
