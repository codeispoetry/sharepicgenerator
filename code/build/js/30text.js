var text=draw.text("hallo");
var textfield = draw.group();
textfield.draggable();


$('#text').bind('input propertychange', function() {
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
});
