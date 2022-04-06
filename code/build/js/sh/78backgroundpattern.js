/* eslint-disable max-len */
const bgpattern = {
  svg: draw.group(),

  draw() {
    bgpattern.svg.remove();

    bgpattern.svg = draw.group();
    const w = draw.width();
    const h = draw.height();

    const colorSet = [
      {
        a: '#006c81', b: '#002e4e', c: '#253481', d: '#009a3a',
      },
      {
        a: '#a00051', b: '#c52765', c: '#035a38', d: '#008052',
      },
      {
        a: '#ec8824', b: '#e94d16', c: '#035a38', d: '#008052',
      },
    ];

    const color = $('#backgroundColorSet').val();

    draw.rect(w, h * 0.4).fill(colorSet[color].a).addTo(bgpattern.svg);

    // draw.path(`M0 0 V${h * 0.4} C${w * 0.4} ${h * 0.4} ${w * 0.9} ${h * 0.4} ${w * 0.9} 0 z`) 
    //   .fill(colorSet[color].b)
    //   .addTo(bgpattern.svg);

    draw.circle(h * 0.8).dx(-h * 0.4).dy(-h * 0.4).fill(colorSet[color].b)
      .addTo(bgpattern.svg);

    draw.rect(w, h * 0.6).dy(h * 0.4).fill(colorSet[color].c).addTo(bgpattern.svg);
    draw.polygon(`0, ${0.5 * h} ${w * 0.8},${h} 0, ${h}`).fill(colorSet[color].d).addTo(bgpattern.svg);

    const gradient = draw.gradient('linear', (add) => {
      add.stop({ offset: 0.2, color: '#000000', opacity: 0 });
      add.stop({ offset: 1, color: '#000000', opacity: 1 });
    });

    draw.rect(w, h * 0.6).dy(h * 0.4).fill(gradient).opacity(0.5)
      .addTo(bgpattern.svg);

    // eslint-disable-next-line no-undef
    floating.svg.front();
    logo.svg.front();
  },

};

$('#backgroundColorSet').bind('input propertychange', bgpattern.draw);

