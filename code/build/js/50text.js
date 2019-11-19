var textfield = draw.group();
var text=draw.text("");
textfield.draggable();

$('#text').bind('input propertychange', handleText);
handleText();

function handleText() {
    let lines = $('#text').val().split(/\n/);

    text.clear();
    text = draw.text(function(add) {
      
        for(let i = 0; i < lines.length; i++){
            add.tspan(lines[ i ]).newLine();    
        }
       
       // add.tspan('consectetur').fill('#f06')
       // add.tspan('.')
       // add.tspan('Cras sodales imperdiet auctor.').newLine().dx(20)
       
      });

    textfield.add( text );

    text.font({
       family:   'Arvo', 
       size:     20,
       anchor:   'middle',
       leading:  '1.5em'
      })


    setPositionOfTextfield();

    $('#textfieldresize').val( textfield.width() );
}

function setPositionOfTextfield(){
    textfield.x( info.x );
    textfield.y( info.y );
    textfield.size( info.size );
    textfield.front();
}