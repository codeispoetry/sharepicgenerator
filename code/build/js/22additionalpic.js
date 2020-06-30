
const addPic1 = {
    svg: draw.circle(0),
    i: 1,

    draw: function (  ) {

        this.svg.remove();
        this.svg = draw.group().addClass('draggable').draggable();
        this.svg.on('dragmove.namespace', function (event) {
             circleMask.move(pic.x(), pic.y());
        });

        this.svg.on('dragend.namespace', () => {
            $('#addPic' + this.i + 'x').val(Math.round(this.svg.x()));
            $('#addPic' + this.i + 'y').val(Math.round(this.svg.y()));
        });

        var circleMask = draw.circle(0).fill({color: '#fff'});
        var pic = draw.image($('#addpicfile' + this.i).val(), () => {
            let radius = pic.height();
            if( pic.height() > pic.width() ){
                radius = pic.width();
            }

            if( $('#addpicrounded' + this.i).prop("checked")) {
                circleMask.move(pic.width()/2, pic.height() / 2 ).radius( radius / 2  - 3).back();
                pic.maskWith(circleMask);
            }else{
                circleMask.size(0);
            }
            this.svg.add(pic);
            this.svg.move( $('#addPic' + this.i +'x').val(), $('#addPic' + this.i + 'y').val( ) );


            this.resize( );
            this.svg.move( $('#addPic' + this.i +'x').val(), $('#addPic' + this.i + 'y').val( ) );


            text.svg.front();
        });
    },

    delete: function(){
        this.svg.remove();
        this.svg = draw.circle(0);
    },

    resize: function ( ) {
        let percentage = draw.width() * parseInt($('#addPicSize' + this.i).val()) / 100;
        this.svg.size(percentage);
    }

};

const addPic2 = Object.assign({}, addPic1);
addPic2.i = 2;

$('#addPicSize1').bind('input propertychange', function() { addPic1.resize(); });
$('#addpicrounded1').bind('change', function() { addPic1.draw(); } );
$('#addpicdelete1').bind('click', function() { addPic1.delete(); } );

$('#addPicSize2').bind('input propertychange', function() { addPic2.resize(); });
$('#addpicrounded2').bind('change', function() { addPic2.draw(); } );
$('#addpicdelete2').bind('click', function() { addPic2.delete(); } );



