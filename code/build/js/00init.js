const draw = SVG().addTo('#canvas');
var info = { foo: null};

const bgpic = {
    width: 800,
    height: 450,
    originalWidth: 1920,
    originalHeight: 1080,
    filename: '../assets/bg_small.jpg'
};

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
    window.setTimeout( load, 1000 );


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
