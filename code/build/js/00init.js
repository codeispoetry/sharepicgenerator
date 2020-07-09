const draw = SVG().addTo('#canvas');
var info = { foo: null};

const secondaryfont = {
    family: 'ArvoGruen',
    size: 15,
    anchor: 'left',
    weight: 700
};

$(document).ready(function () {
    $('#width').val( bgpic.originalWidth );
    $('#height').val( bgpic.originalHeight );

    pin.draw();
    window.setTimeout(text.draw, 10);
    afterUpload(bgpic);


    $('[data-click]').click(function(){
        window[ $(this).data('click')]();
    })
});

function message( text = false ){
    if( !text ){
        $('#message').hide();
        return;
    }
    $('#message').show().html( text );
}


function redrawCockpit(){
   if(config.video){
        $('.novideo').addClass("d-none");
   }else{
        $('.novideo').removeClass("d-none");
   }
}

function hide( className ){
    $( '.' + className ).addClass( 'd-none' );
}

function show( className ){
    $( '.' + className ).removeClass( 'd-none' );
}

function basename(path) {
    let name = path.split('/').reverse()[0];
    return name.split('.')[0]
}

function debug(){
    $('.debug').show();
}
