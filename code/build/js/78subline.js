$('#subline').bind('input propertychange', handleSubline);

var subline = draw.text("");


function handleSubline(){
    subline.remove();
    subline = draw.text( $('#subline').val().toUpperCase() ) .fill( 'white').move( 15, draw.height() - 24 );

    subline.font({
        family:   'Arvo', 
        size:     15,
        anchor:   'left',
        weight:   600
    })
}