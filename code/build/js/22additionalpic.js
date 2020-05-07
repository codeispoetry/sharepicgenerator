
const addPic = {
    svg: draw.circle(0),

    draw: function () {

        addPic.svg.remove();
        addPic.svg = draw.group().addClass('draggable').draggable();
        addPic.svg.on('dragmove.namespace', function (event) {
             circleMask.move(pic.x(), pic.y());
        });

        var circleMask = draw.circle(10).fill({color: '#fff'});

        var pic = draw.image($('#addpicfile').val(), function (event) {

            circleMask.move(pic.width()/2, pic.height() / 2 ).radius( pic.height() / 2  - 5).back();
            pic.maskWith( circleMask );
            addPic.svg.add(pic);

            addPic.resize();
        });
    },

    resize: function () {
        let percentage = draw.width() * parseInt($('#addPicSize').val()) / 100;
        addPic.svg.size(percentage);
    }

};


$('#addPicSize').bind('input propertychange', addPic.resize);

