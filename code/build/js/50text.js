const text = {
    svg: draw.text(''),
    lineheights: [26, 40],
    colors: ['#449d2f', '#255119'],
    fontsizes: [23, 40],
    yBiases: [0, -3],
    linemargin: 4,
    paddingLr: 5,
    font: {
        family: 'Arvo',
        anchor: 'left',
        leading: '1.25em',
        weight: 'bold'
    },

    draw: function () {

        text.svg.remove();
        text.svg = draw.group().addClass('draggable').draggable();

        text.svg.on('dragend.namespace', function (event) {
            $('#textX').val(this.x());
            $('#textY').val(this.y());
            text.bounce();
        });

        let y = 0;

        $('#text').val().split(/\n/).forEach(function (value, index, array) {
                let style = /^!/.test(value) ? 1 : 0;
                value = value.replace(/^!/, '').toUpperCase();

                let t = draw.text(value).font({...text.font, ...{size: text.fontsizes[style]}}).fill(text.colors[style]).move(0, y + text.yBiases[style]);

                let r = draw.rect(t.length() + 2 * text.paddingLr, text.lineheights[style]).fill('white').move(-text.paddingLr, y);


                text.svg.add(r).add(t);
                y += text.lineheights[style] + text.linemargin;
            }
        );

        text.svg.move(parseInt($('#textX').val()), parseInt($('#textY').val())).size(parseInt($('#textsize').val()));

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


$('#text').bind('input propertychange', text.draw);
$('#textsize').bind('input propertychange', text.draw);

