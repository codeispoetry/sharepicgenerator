$('#uploadfile').change(function(event){
   
    let input = event.target;

    let reader = new FileReader();
    reader.onload = function(){
        let dataURL = reader.result;
      
        $.post( "upload.php", { data: reader.result })
        .done(function( data ) {
            let obj = JSON.parse( data );
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
       
        $('#textfieldresize').attr('max', draw.width());
        $('#pinresize').attr('min', draw.width() / 10 );
        $('#pinresize').attr('max', draw.width() / 4 );

        image.back();
        setLogoPosition();
        handleSubline();
     })
}


