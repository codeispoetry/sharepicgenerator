const text = {
  svg: draw.text(''),
  lineheights: [26, 40],
  colors: ['#449d2f', '#255119'],
  fontsizes: [23, 40],
  yBiases: [0, -3],
  linemargin: 4,
  paddingLr: 5,
  font: {
    family: 'ArvoGruen',
    anchor: 'left',
    leading: '1.25em',
    weight: 'normal',
  },

  draw() {
    text.svg.remove();
    text.svg = draw.group().addClass('draggable').attr('id', 'svg-text').draggable();

    text.svg.on('dragend.namespace', function (event) {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
      text.bounce();
    });

    let y = 0;

    $('#text').val().split(/\n/).forEach((value, index, array) => {
      const style = /^!/.test(value) ? 1 : 0;
      value = value.replace(/^!/, '').toUpperCase();

      const t = draw.text(value).font(Object.assign(text.font, { size: text.fontsizes[style] })).fill(text.colors[style]).move(0, y + text.yBiases[style]);

      let barWidth = t.length() + 2 * text.paddingLr;
      if (value == '') {
        barWidth = 0;
      }
      const r = draw.rect(barWidth, text.lineheights[style]).fill('white').move(-text.paddingLr, y);

      text.svg.add(r).add(t);
      y += text.lineheights[style] + text.linemargin;
    });

    text.svg.move(parseInt($('#textX').val()), parseInt($('#textY').val())).size(parseInt($('#textsize').val()));

    pin.draw();
  },

  bounce() {
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
    if (this.svg.y() > draw.height() - this.svg.height() - 40) {
      $('#textY').val(draw.height() - this.svg.height() - 40);
      this.draw();
    }
  },
};

$('#text').bind('input propertychange', text.draw);
$('#textsize').bind('input propertychange', text.draw);
