const bgpattern = {
  svg: draw.group(),

  draw() {
    this.svg.remove();

    this.svg = draw.group();
    const w = draw.width();
    const h = draw.height();

    draw.rect(w, h * 0.4).fill('#ec8824').addTo(this.svg);
    draw.ellipse(2 * w, h).dx(-w * 1.2).dy(-h * 0.6).fill('#e94d16').addTo(this.svg);

    draw.rect(w, h * 0.6).dy(h * 0.4).fill('#035a38').addTo(this.svg);
    draw.polygon(`0, ${0.5 * h} ${w * 0.8},${h} 0, ${h}`).fill('#008052').addTo(this.svg);

    // eslint-disable-next-line no-undef
    floating.svg.front();
    logo.svg.front();
  },

};

