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
    
    if( mode == 'pixabay'){
        copyrights[ mode ] = "Foto: " + message + "@pixabay.com";
    }else{
        copyrights[ mode ] = "Icon: " + message;
    }

    $('#copyright').val( Object.values(copyrights).join(', ') );
    copyright.draw();
    copyright.draw(); // has to be here twice. Don't know, why. Settimeout did not work

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
            .fill( copyrightColors[ copyrightColorIndex ])
            .move( 10, draw.height() - 12 )
            .rotate( -90, copyright.svg.x(), copyright.svg.y() )
            ;

    }
}


