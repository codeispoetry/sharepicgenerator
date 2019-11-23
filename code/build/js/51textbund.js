const text = {
    svg: draw.text(''),
    colors: ['#ffffff', '#ffee00'],
    fontsizes: [20, 20],
    lineheights: [20, 20],
    yBiases: [0, 0],
    linemargin: 0,
    paddingLr: 5,
    font: {
        family: 'Arvo',
        anchor: 'left',
        leading: '1.0em'
    },
    fontoutsidelines: {
        family: 'Arvo',
        size: 6,
        anchor: 'left',
        leading: '1.0em',
        weight: 300
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
        let fontweight = (lines.length <= 3 ) ? 700 : 300;
        console.log( fontweight);

        lines.forEach(function (value, index, array) {
                let style = /^!/.test(value) ? 1 : 0;
                 
                value = value.replace(/^!/, '').toUpperCase();

                let t = draw.text(value).font({...text.font, ...{weight: fontweight, size: text.fontsizes[style]}}).fill(text.colors[style]).move(0, y + text.yBiases[style]);

                text.svg.add(t);
                y += text.lineheights[style] + text.linemargin;
            }
        );

        // add upper and lower line
        let linebefore = draw.rect( text.svg.width(), 2).fill( '#ffffff').dy( -4 );
        let lineafter  = linebefore.clone().dy( text.svg.height() + 6 );
        text.svg.add( linebefore);
        text.svg.add( lineafter );

        // text above and below the line
        let textbefore = draw.text( $('#textbefore').val() ).font( text.fontoutsidelines ).fill('#ffffff').dy(-14);
        let textafter = draw.text( $('#textafter').val() ).font( text.fontoutsidelines ).fill('#ffffff').dy( text.svg.height() - 2 );
        text.svg.add( textbefore );
        text.svg.add( textafter );

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

