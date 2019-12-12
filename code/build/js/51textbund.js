const text = {
    svg: draw.text(''),
    colors: ['#ffffff', '#ffee00'],
    fontsizes: [20, 20],
    lineheight: 20,
    yBiases: [0, 0],
    linemargin: 0,
    paddingLr: 5,
    font: {
        anchor: 'left',
        leading: '1.0em',
        size: 20
    },
    fontoutsidelines: {
        family: 'ArvoGruen',
        size: 6,
        anchor: 'left',
        leading: '1.0em',
    },

    draw: function () {
        text.svg.remove();
        text.svg = draw.group().addClass('draggable').draggable();

        text.svg.on('dragend.namespace', function (event) {
            $('#textX').val(Math.round(this.x()));
            $('#textY').val(Math.round(this.y()));
            text.bounce();
        });

        let y = 0;
        let lines = $('#text').val().split(/\n/);
        let fontfamily = (lines.length <= 3) ? 'ArvoGruen' : 'Arvo';

        lines.forEach(function (value, index, array) {

                let style = 1;

                values = value.toUpperCase().split(/\[|\]/);

                let t = draw.text(function (add) {
                    for(let i = 0; i<values.length; i++) {
                        style = (style == 0 ) ? 1 : 0;
                        console.log(style);
                        add.tspan( values[i] ).fill(text.colors[style]).font({...text.font, ...{family: fontfamily}});
                    }
                });

                t.move(0, y + text.yBiases[style]);

                text.svg.add(t);
                y += text.lineheight + text.linemargin;
            }
        );

        // add upper and lower line
        let linebefore = draw.rect(text.svg.width(), 2).fill('#ffffff').dy(-4);
        let lineafter = linebefore.clone().dy(text.svg.height() + 6);
        text.svg.add(linebefore);
        text.svg.add(lineafter);

        // text above and below the line
        let textbefore = draw.text($('#textbefore').val()).font(text.fontoutsidelines).fill('#ffffff').dy(-14);
        let textafter = draw.text($('#textafter').val()).font(text.fontoutsidelines).fill('#ffffff').dy(text.svg.height() - 2);
        text.svg.add(textbefore);
        text.svg.add(textafter);


        // green background behind text
        if ($('#design').val() == 'textbackground') {
            let textbackgroundpadding = 10;
            let textbackground = draw.rect(text.svg.width() + 2 * textbackgroundpadding, text.svg.height() + 2 * textbackgroundpadding).fill('#46962b').move(-textbackgroundpadding, -14).back();

            if ($('#textbefore').val()) {
                textbackground.dy(-6);
            }

            if ($('#textbefore').val() && $('#textafter').val()) {
                textbackground.height(textbackground.height() - 6);
            }

            text.svg.add(textbackground);
            textbackground.back();
        }

        text.svg.move(parseInt($('#textX').val()), parseInt($('#textY').val())).size(parseInt($('#textsize').val()));

        pin.draw();
    },

    bounce: function () {
        if (this.svg.x() < 15) {
            $('#textX').val(15);
            this.draw();
        }
        if (this.svg.x() > draw.width() - this.svg.width() - 15) {
            $('#textX').val(draw.width() - this.svg.width() - 15);
            this.draw();
        }
        if (this.svg.y() < 30) {
            $('#textY').val(30);
            this.draw();
        }
        if (this.svg.y() > draw.height() - this.svg.height() - 30) {
            $('#textY').val(draw.height() - this.svg.height() - 30);
            this.draw();
        }
    },
};


$('#text, #textbefore, #textafter').bind('input propertychange', text.draw);
$('#textsize').bind('input propertychange', text.draw);

