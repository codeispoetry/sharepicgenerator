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
        pin.svg.remove();
        pin.svg = draw.group();
        if ($('#pintext').val() == "") return;

        pin.svg.addClass('draggable').draggable();

        pin.svg.on('dragstart.namespace', (e) => {
            pin.svg.rotate(9, draw.width(), pin.svg.y());
        })
        pin.svg.on('dragmove.namespace', (e) => {
            const {handler, box} = e.detail
            e.preventDefault()
          
            let {x, y} = box
    
            handler.move(draw.width()-pin.svg.width(),y);

            $('#pinX').val(Math.round(pin.svg.x()));
            $('#pinY').val(Math.round(pin.svg.y()));
        });
        pin.svg.on('dragend.namespace', (e) => {
            pin.svg.rotate(-9, draw.width(), pin.svg.y());
        })

        // text
        let pintext = draw.text($('#pintext').val()).font(pinfont).fill('#ffffff').move( 28,6);

        // background
        let pinwidth = pintext.length() + 40;
        let pinheight = 30;
        let pinbackground = draw.polygon([
                [0,0],
                [ pinwidth,0],
                [ pinwidth,pinheight],
                [ 0,pinheight],
                [ pinheight/2,pinheight/2]
        ]
            ).fill('#e6007e');
       

        // and in reverse order
        pin.svg.add(pinbackground);
        pin.svg.add(pintext);

        pin.svg.move( draw.width() - pin.svg.width(), $('#pinY').val());
        pin.svg.rotate(-9, draw.width(), pin.svg.y());

        pin.svg.front();
    },

    bounce: function () {
     
    }
};



$('#pintext').bind('input propertychange', pin.draw);
