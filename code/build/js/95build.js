function build(){
    info.x = 20;
    info.y = 20;
    info.size = 100;
    $('#text').val("Das ist ein\n!Fuchs");
    handleText();

    uploadImageByUrl( 'persistent/fox.jpg' );
}

build();

