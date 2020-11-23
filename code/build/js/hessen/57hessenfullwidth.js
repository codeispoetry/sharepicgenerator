/* eslint-disable no-undef */
const hessenfullwidth = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ffff00', '#ffee00'],
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },
  fontoutsidelines: {
    family: 'ArvoGruen',
    size: 6,
    anchor: 'left',
    leading: '1.0em',
  },

  draw() {
    if (config.layout !== 'hessenfullwidth') {
      return;
    }

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    // textDragging();

    let y = 0;

    // let lines = '„' + $('#text').val() + '“';

    let lines = $('#text').val().toUpperCase();
    const quotationMarks = ['„', '“'];
    let qmI = 0;
    while ((lines.match(/"/g) || []).length) {
      lines = lines.replace(/"/, quotationMarks[qmI]);
      qmI = (qmI + 1) % 2;
    }

    lines = lines.replace(/\n$/, '').split(/\n/);
    const fontfamily = 'ArvoGruen';

    const lineBeginsY = [];
    const linesRendered = [];
    let color;
    const ts = [];

    lines.forEach((value, index) => {
      let style = 1;

      // the main text
      const values = value.split(/\[|\]/);

      const t = draw.text((add) => {
        for (let i = 0; i < values.length; i++) {
          style = (style === 0) ? 1 : 0;

          color = hessenfullwidth.colors[style];
          if (style === 0) {
            color = textColors[$('#textColor').val()];
          }

          add.tspan(values[i]).fill(color).font(
            Object.assign(hessenfullwidth.font, { family: fontfamily }),
          );

          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });

      t.move(10, y);

      y += (t.rbox().h) + hessenfullwidth.linemargin;

      lineBeginsY[index] = y;
      linesRendered[index] = t;
      ts.push(t);
    });

    // the fonds with the edge
    const gradient = draw.gradient('radial', (add) => {
      add.stop(0, '#ffee00');
      add.stop(0.5, '#46962b');
    });
    gradient.from(1.1, 0).to(0.9, 1).radius(1.1);

    const fondsHeight = y + hessenfullwidth.lineheight * 3.5;
    const fonds = draw.polygon(`
        0, ${hessenfullwidth.lineheight * -0.4}
        ${draw.width() * 0.9}, ${hessenfullwidth.lineheight * -0.4} 
        ${draw.width() * 0.96}, ${draw.width() * -0.065}
        ${draw.width() * 0.96}, ${fondsHeight}
        0, ${fondsHeight}
        `).fill(gradient).back();

    text.svg.add(fonds);

    const url = draw.text('gruene-hessen.de')
      .font({ family: 'ArvoGruen', size: 12 })
      .fill('white').move(draw.width() - 160, fondsHeight - 20);
    text.svg.add(url);

    const smalllogo = draw.image('/assets/logos/sonnenblume.svg', () => {
      smalllogo.size(40);
    });
    smalllogo.move(10, fondsHeight - 50);
    text.svg.add(smalllogo);
    $('#logoselect').val('void');
    logo.load();

    const claim = draw.text('Hier kommt\nderClaim')
      .font({ family: 'Arvo', size: 12})
      .fill('white').move(60, fondsHeight - 48);
    text.svg.add(claim);

    ts.forEach((t) => {
      text.svg.add(t);
    });

    eraser.front();
    showActionDayHint();

    text.svg.move(draw.width() * 0.02, draw.height() - text.svg.height() - draw.width() * 0.02);
  },

};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext').bind('input propertychange', hessenfullwidth.draw);
