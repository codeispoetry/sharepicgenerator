$('#pinsize').bind('input propertychange', function () {
    pin.draw();
});

$('.pinreset').click(function () {
    $('#pinY').val( draw.height() / 2);
    pin.draw();
});


const pinfont = {
    family: 'Arvo',
    size: 15,
    anchor: 'left',
    weight: 300
};

const pin = {
    isLoaded: false,

    svg: draw.text(''),


    draw() {
        $('#eyecatchersize').prop('disabled', ($('#pintext').val().length == 0 ));

        let countLines = ($('#pintext').val().match(/\n/g) || []).length; // start with 0

        if( countLines > 1 ){
            $('#pintext').val( $('#pintext').val().replace(/\n.*$/,'') );
        }

        pin.svg.remove();
        pin.svg = draw.group();
        if ($('#pintext').val() == "") return;

        pin.svg.addClass('draggable').draggable();

        pin.svg.on('dragstart.namespace', (e) => {
            pin.svg.rotate(9, draw.width(), pin.svg.y());
        });
        pin.svg.on('dragmove.namespace', (e) => {
            const {handler, box} = e.detail;
            e.preventDefault();
          
            let {x, y} = box;
    
            handler.move(draw.width()-pin.svg.width(),y);


        });
        pin.svg.on('dragend.namespace', (e) => {
            pin.svg.rotate(-9, draw.width(), pin.svg.y());
            $('#pinX').val(Math.round(pin.svg.x()));
            $('#pinY').val(Math.round(pin.svg.y()));
        });

        // text
        let pintext = draw.text($('#pintext').val()).font(pinfont).fill('#ffffff');

        // background
        let pinwidth = pintext.rbox().w + 40 + ( countLines * 20 );
        let pinheight = pintext.rbox().h + 20;
        
        let pinbackground = draw.polygon([
                [0,0],
                [ pinwidth,0],
                [ pinwidth,pinheight],
                [ 0,pinheight],
                [ pinheight/2,pinheight/2]
        ]
            ).fill('#e6007e');
       
       
        pintext.move( 28 + (countLines * 10), 9);
        pintext.attr("xml:space","preserve").attr("style","white-space:pre");

        // and in reverse order
        pin.svg.add(pinbackground);
        pin.svg.add(pintext);

        pin.svg.move( draw.width() - pin.svg.width(), $('#pinY').val());
        let eyecatchersize = $('#eyecatchersize').val() / 100 ;
        pin.svg.scale( eyecatchersize,eyecatchersize,draw.width(),$('#pinY').val());
        pin.svg.rotate(-9, draw.width(), pin.svg.y());

        pin.svg.front();
    },

    bounce: function () {
     
    }
};



$('#pintext, #eyecatchersize').bind('input propertychange', pin.draw);
