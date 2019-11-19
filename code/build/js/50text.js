var textfield=draw.group();


$('#text').bind('input propertychange', handleText);
handleText();

function handleText() {
    let texts = [];
    let rects = [];
    let lines = $('#text').val().split(/\n/);
    let colors = [ '#449d2f', '#255119',];
    let fontsizes = [ 20, 40 ];
    let lineheights = [ 30, 60 ];
    let fontYBiases = [0, -8 ];
    let linemargin = 4;
    let x = 0;
    let y = 0;
    let paddingLr = 5;

    textfield.remove();
    textfield = draw.group().addClass('draggable').draggable();


      for(let i = 0; i < lines.length; i++){
        let line = lines[ i ].toUpperCase();

        let variant = 0;
        if( line.substring(0,1) == "!"){
            line = line.substring(1);
            variant = 1;
        }
        

        let color = colors[ variant ];
        let fontsize = fontsizes[ variant ];
        let lineheight = lineheights[ variant ];
        let fontYBias = fontYBiases[ variant ];

       
        texts[i] = draw.text( line ).fill( color ).move( x + paddingLr, y + fontYBias);
        texts[i].font({
            family:   'Arvo', 
            size:     fontsize,
            anchor:   'left',
            leading:  '1.5em',
            weight:   'bold'
        })
        rects[i] = draw.rect( texts[i].length() + 2 * paddingLr , lineheight).fill( 'white').move(x,y);

        y += lineheight + linemargin;

        textfield.add(rects[ i ]).add( texts[i] );
       
      }

    setPositionOfTextfield();

    $('#textfieldresize').val( textfield.width() );
}

function setPositionOfTextfield(){
    textfield.x( info.x );
    textfield.y( info.y );
    textfield.size( info.size );
    textfield.front();
}