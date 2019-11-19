$('#uploadfile').change(function(event){
    $('#uploadfile').prop('disabled',true);
    $('#upload .message').html('Lade hoch...');
    let input = event.target;

    let reader = new FileReader();
    reader.onload = function(){
      
        $.post( "upload.php", { data: reader.result })
        .done(function( data ) {
            let obj = JSON.parse( data );
             $('#uploadfile').prop('disabled',false);
             $('#upload .message').html('');
             afterUpload( obj );
        });

    };
    reader.readAsDataURL(input.files[0]);

});

var image = draw.circle(0);
function afterUpload( data ){
    draw.size(data.width, data.height);
    info.originalWidth = data.originalWidth;
    info.originalHeight = data.originalHeight;

    image.remove();

    image = draw.image(data.filename, function (event) {
        image.size( draw.width(), draw.height() );
       
        setSize( draw.width(), draw.height() );
        redraw();
     })
}


