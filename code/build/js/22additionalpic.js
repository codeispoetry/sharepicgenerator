
const addPic1 = {
    svg: draw.circle(0),
    circleMask: draw.circle( 0 ),
    pic: draw.circle( 0 ),
    i: 1,

    draw: function (  ) {

        this.svg.remove();
        this.svg = draw.group().addClass('draggable').draggable();

        this.svg.on('dragmove.namespace', () => {
             this.circleMask.move(this.pic.x(), this.pic.y());
        });

        this.svg.on('dragend.namespace', () => {
            $('#addPic' + this.i + 'x').val(Math.round(this.svg.x()));
            $('#addPic' + this.i + 'y').val(Math.round(this.svg.y()));
        });

        this.circleMask = draw.circle(0).fill({color: '#fff'});
        this.pic = draw.image($('#addpicfile' + this.i).val(), () => {
            let radius = this.pic.height();
            if( this.pic.height() > this.pic.width() ){
                radius = this.pic.width();
            }

            if( $('#addpicrounded' + this.i).prop("checked")) {
                this.circleMask.move( this.pic.width()/2, this.pic.height() / 2 ).radius( radius / 2  - 3).back();
                this.pic.maskWith(this.circleMask);
            }else{
                this.circleMask.size(0);
            }
            this.svg.add(this.pic);
            this.svg.move( $('#addPic' + this.i +'x').val(), $('#addPic' + this.i + 'y').val( ) );

            this.resize( );
            this.svg.move( $('#addPic' + this.i +'x').val(), $('#addPic' + this.i + 'y').val( ) );
            this.setMask( );

            text.svg.front();
        });
    },

    setMask: function(){
        this.circleMask.move(this.pic.x(), this.pic.y());
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

function addpicAlign(){
    let y = addPic1.svg.y();
    let size = ( addPic1.pic.height() / addPic2.pic.height() ) * $('#addPicSize1').val()  ;
console.log( size )
    $('#addPic2y').val( y );
    $('#addPicSize2').val( size );

    addPic2.draw();
}

const addPic2 = Object.assign({}, addPic1);
addPic2.i = 2;

$('#addPicSize1').bind('input propertychange', function() { addPic1.resize(); });
$('#addpicrounded1').bind('change', function() { addPic1.draw(); } );
$('#addpicdelete1').bind('click', function() { addPic1.delete(); } );

$('#addPicSize2').bind('input propertychange', function() { addPic2.resize(); });
$('#addpicrounded2').bind('change', function() { addPic2.draw(); } );
$('#addpicdelete2').bind('click', function() { addPic2.delete(); } );



