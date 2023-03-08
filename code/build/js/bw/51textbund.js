const text = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ffffff', '#ffee00'],
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },
  fontoutsidelines: {
    family: 'Arvo Gruen',
    size: 10,
    anchor: 'left',
    leading: '1.0em',
  },

  draw() {
    if (config.layout !== undefined && config.layout !== 'lines') {
      return;
    }

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    textDragging();

    let y = 0;

    let lines = $('#text').val();

    const quotationMarks = ['„', '“'];
    let qmI = 0;
    while ((lines.match(/"/g) || []).length) {
      lines = lines.replace(/"/, quotationMarks[qmI]);
      qmI = (qmI + 1) % 2;
    }

    lines = lines.replace(/\n$/, '').split(/\n/);

    const fontfamily = (lines.length <= 3) ? 'Arvo Gruen' : 'Arvo';
    const longestLine = lines.reduce((a, b) => (a.length > b.length ? a : b));

    const widthSameLineHeihgts = 16 * longestLine.length;

    const lineBeginsY = [];
    const linesRendered = [];
    let color;

    lines.forEach((value, index) => {
      let style = 1;
      let changedValue = value;

      // the main text
      if (lines.length < 4) {
        changedValue = changedValue.toUpperCase();
      }
      const values = changedValue.split(/\[|\]/);

      let t = draw.text((add) => {
        for (let i = 0; i < values.length; i++) {
          style = (style === 0) ? 1 : 0;

          color = text.colors[style];
          if (style === 0) {
            // eslint-disable-next-line prefer-destructuring
            color = textColors[0];
            // always white, and not  $('#textColor').val()
          }

          add.tspan(values[i]).fill(color).font(Object.assign(text.font, { family: fontfamily }));

          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });

      t.move(0, y);

      if ($('#textsamesize').prop('checked')) {
        // the number defines the size of the white bars
        t = draw.group().add(t).size(widthSameLineHeihgts);
      }

      y += (t.rbox().h) + text.linemargin;

      lineBeginsY[index] = y;
      linesRendered[index] = t;
      text.svg.add(t);
    });

   

    // add upper and lower line
    color = 'white';
    const linebefore = draw.rect(text.svg.width(), 2).fill(color).dy(-4);
    const lineafter = linebefore.clone().dy(text.svg.height() + 6);
    text.svg.add(linebefore);
    text.svg.add(lineafter);

    // text above and below the line
    const textbeforeParts = $('#textbefore').val().split(/\[|\]/);
    let style = 1;
    const textbefore = draw.text((add) => {
      for (let i = 0; i < textbeforeParts.length; i++) {
        style = (style === 0) ? 1 : 0;
        add.tspan(textbeforeParts[i]).fill(text.colors[style]).font(text.fontoutsidelines);
        add.attr('xml:space', 'preserve');
        add.attr('style', 'white-space:pre');
      }
    });
    textbefore.dy(-7);

    const textafterParts = $('#textafter').val().split(/\[|\]/);
    style = 1;
    const textafter = draw.text((add) => {
      for (let i = 0; i < textafterParts.length; i++) {
        style = (style === 0) ? 1 : 0;
        add.tspan(textafterParts[i]).fill(text.colors[style]).font(text.fontoutsidelines);
        add.attr('xml:space', 'preserve');
        add.attr('style', 'white-space:pre');
      }
    });
    textafter.dy(text.svg.height() + 7);

    text.svg.add(textbefore);
    text.svg.add(textafter);

    // green background behind text
    if ($('#greenbehindtext').prop('checked')) {
      const textbackgroundpadding = 10;
      const textbackground = draw.rect(text.svg.width() + 2 * textbackgroundpadding,
        text.svg.height() + 2 * textbackgroundpadding)
        .fill('#46962b')
        .move(-textbackgroundpadding, -14).back();

      if ($('#textbefore').val()) {
        textbackground.dy(-9);
      }

      if ($('#textbefore').val() && $('#textafter').val()) {
        textbackground.height(textbackground.height() - 6);
      }

      text.svg.add(textbackground);
      textbackground.back();
    }

    // gray layer behind text
    text.grayBackground.remove();
    if ($('#graybehindtext').prop('checked')) {
      const grayGradient = draw.gradient('radial', (add) => {
        add.stop({ offset: 0, color: $('#colorbehindtext').val(), opacity: 0.9 });
        $('#colorbehindtext').val()
      });
      grayGradient.from(0.5, 0.5).to(0.5, 0.5).radius(0.5);

      text.grayBackground = draw.rect(text.svg.width(), text.svg.height())
        .fill({ color: grayGradient, opacity: 0.3 })
        .back();
    }

    text.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10)).size(parseInt($('#textsize').val(), 10));
    text.positionGrayBackground();

  },

  positionGrayBackground() {
    text.grayBackground.x(text.svg.x()).y(text.svg.y()).size(parseInt($('#textsize').val(), 10));
    text.grayBackground.transform({ scale: 2.5 });
    background.svg.back();
   // background.colorlayer.back();
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
    if (this.svg.y() > draw.height() - this.svg.height() - 30) {
      $('#textY').val(draw.height() - this.svg.height() - 30);
      this.draw();
    }
  },
};

$('#text, #textbefore, #textafter, #textsize, #textsamesize, #greenbehindtext, #graybehindtext').bind('input propertychange', text.draw);
