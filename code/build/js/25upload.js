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

var image;
function afterUpload( data ){
    draw.size(data.width, data.height);

    image = draw.image(data.filename, function (event) {
        image.size( draw.width(), draw.height() );
     })

}

