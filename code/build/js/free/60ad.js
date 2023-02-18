const ad = {
  svg: draw.text(''),
  font: {
    family: 'Arial',
    anchor: 'left',
    leading: '1.05em',
    size: 10,
  },

  draw() {

    ad.svg = draw.text('sharepicgenerator.de')
      .font(Object.assign(ad.font))
      .fill('#000000')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');
    
    ad.setPosition();
  },

  setPosition() {
    const w = ad.svg.bbox().width;
    const h = ad.svg.bbox().height;
    const x = draw.width() - w - 10;
    const y = draw.height() - h - 10;
    ad.svg.move(x, y);
  }
};

