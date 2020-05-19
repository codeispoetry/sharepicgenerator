
const addPic = {
    svg: draw.circle(0),

    draw: function () {

        addPic.svg.remove();
        addPic.svg = draw.group().addClass('draggable').draggable();
        addPic.svg.on('dragmove.namespace', function (event) {
             circleMask.move(pic.x(), pic.y());
        });

        var circleMask = draw.circle(0).fill({color: '#fff'});

        var pic = draw.image($('#addpicfile').val(), function (event) {

            let radius = pic.height();
            if( pic.height() > pic.width() ){
                radius = pic.width();
            }

            if( $('#addpicrounded').prop("checked")) {
                circleMask.move(pic.width()/2, pic.height() / 2 ).radius( radius / 2  - 3).back();
                pic.maskWith(circleMask);
            }else{
                circleMask.size(0);
            }
            addPic.svg.add(pic);

            addPic.resize();

            text.svg.front();
        });
    },

    delete: function(){
        addPic.svg.remove();
        addPic.svg = draw.circle(0);
    },

    resize: function () {
        let percentage = draw.width() * parseInt($('#addPicSize').val()) / 100;
        addPic.svg.size(percentage);
    }

};


$('#addPicSize').bind('input propertychange', addPic.resize);
$('#addpicrounded').bind('change', addPic.draw);
$('#addpicdelete').bind('click', addPic.delete);



