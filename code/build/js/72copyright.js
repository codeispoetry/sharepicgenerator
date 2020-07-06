$('#copyright').bind('input propertychange', function () {
    copyright.draw();
});

$('.copyright-change-color').click( function(){
    copyrightColorIndex++;
    copyrightColorIndex %= copyrightColors.length;
    copyright.draw();
});

let copyrights = { }
function setCopyright( message, mode){

    if( message == undefined ){
        return false;
    }

    if( mode == 'pixabay'){
        copyrights[ mode ] = "Foto: " + message + "@pixabay.com";
    }else{
        copyrights[ mode ] = "Icon: " + message;
    }

    show( 'show-copyright');
    $('#copyright').val( Object.values(copyrights).join(', ') );
    copyright.draw();
}


var copyrightColors = ["white","black","#46962b","#E6007E","#FEEE00"];
var copyrightColorIndex = 0;

const copyrightfont = {
    family: 'Arial',
    size: 9,
    anchor: 'left',
    weight: 300
};

const copyright = {

    svg: draw.text(''),

    draw() {
        copyright.svg.remove();

        copyright.svg = draw.text($('#copyright').val())
            .font(copyrightfont)
            .fill( copyrightColors[ copyrightColorIndex ]);

        let y;

        switch( $('#copyrightPosition').val() ){
            case "upperLeft":
                y = copyright.svg.length() + 12;
                break;
            default:
                y = draw.height() - 12;
        }

        copyright.svg.move( 10, y )
            .rotate( -90, copyright.svg.x(), copyright.svg.y() )
            ;

    }
};


