/* eslint-disable no-undef */
const hessenfullwidth = {
  svg: draw.text(''),
  smalllogo: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ffff00', '#ffee00'],
  lineheight: 22,
  linemargin: -1,
  paddingLr: 5,
  font: {
    anchor: 'left',
    leading: '1.0em',
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

    let isPortrait = false;
    if (draw.height() > draw.width()) {
      isPortrait = true;
    }

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    hessenfullwidth.smalllogo.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if (typeof nolines.url !== 'undefined') {
      nolines.url.remove();
    }
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    // textDragging();

    let y = 0;

    // let lines = '„' + $('#text').val() + '“';

    let lines = $('#text').val();
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

    const longestLineCount = Math.max(...(lines.map((el) => el.length)));

    let leftSideX = draw.width() * 0.025;
    if (longestLineCount < 20) {
      leftSideX = draw.width() * 0.3;
    }

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

          const size = (isPortrait) ? 14 : 32;

          add.tspan(values[i]).fill(color).font(
            Object.assign(hessenfullwidth.font, { family: fontfamily, size }),
          );

          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });

      t.move(leftSideX + 10, y);

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
        ${leftSideX}, ${hessenfullwidth.lineheight * -0.4}
        ${draw.width() * 0.825}, ${hessenfullwidth.lineheight * -0.4} 
        ${draw.width() * 0.975}, ${draw.width() * -0.0935}
        ${draw.width() * 0.975}, ${fondsHeight}
        ${leftSideX}, ${fondsHeight}
        `).fill(gradient).back();

    text.svg.add(fonds);

    if (!isPortrait) {
      const url = draw.text($('#url').val())
        .font({ family: 'ArvoGruen', size: 14 })
        .fill('white').move(0, fondsHeight - 40);

      const bbox = url.bbox();
      url.x(draw.width() - bbox.width - 35);

      text.svg.add(url);
    }

    const smalllogo = draw.image('/assets/logos/sonnenblume.svg', () => {
      smalllogo.size(40);
      smalllogo.move(leftSideX + 10, fondsHeight - 50);
      text.svg.add(smalllogo);
      text.svg.move(leftSideX, draw.height() - text.svg.height() - draw.width() * 0.02);
    });

    $('#logoselect').val('void');
    logo.load();

    const claim = draw.text('ZUKUNFT MACHEN\nWIR ZUSAMMEN')
      .font({ family: 'Arvo', size: 10 })
      .fill('white').move(leftSideX + 60, fondsHeight - 44);
    text.svg.add(claim);

    ts.forEach((t) => {
      text.svg.add(t);
    });

    eraser.front();
    showActionDayHint();
    checkForOtherTenant();
  },

};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext, #url').bind('input propertychange', hessenfullwidth.draw);
