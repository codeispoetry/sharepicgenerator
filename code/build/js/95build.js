function build(){
    uploadImageByUrl( 'persistent/fox.jpg', function(){
        $('#textX').val( 10 );
        $('#textY').val( 290 );
        $('#textsize').val( 211 );


        $('#pinX').val( 510 );
        $('#pinY').val( 270 );

        $('#text').val("Das ist ein\n!Fuchs");

        pin.draw();
    } );


}

build();