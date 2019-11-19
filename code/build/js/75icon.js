var icon = draw.group();

(function () {

    let circle = draw.circle( 100 ).fill( '#ed038c');
    let square = draw.rect( 50, 50).y(50).fill( '#ed038c');
    let text = draw.text("WEIL\nWIR\nHIER\nLEBEN").fill( '#fff').move( 10, 30 );
    text.font({
        family:   'Arvo', 
        size:     16,
        anchor:   'left',
        leading:  '1.0em',
        weight: 'bold'
       })



    icon.add(circle).add(square).add(text);

    icon.transform({rotate: -13}).move( 200, 200 );

    icon.draggable();
})();