$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pin = {
  isLoaded: false,
  svg: draw.circle(0),

  load(file = '/assets/nrw/eyecatcher.svg') {
    pin.svg.remove();
    pin.svg = draw.image(file, (event) => {
      pin.isLoaded = true;

      pin.draw();
    });
  },

  draw() {
    if (!pin.isLoaded) return false;

    const offsetLeft = -154 / 948;
    pin.svg.size(draw.width() * 0.33).move(offsetLeft * pin.svg.width(), draw.height() - pin.svg.height() - 70);
    pin.svg.front();
  },

  bounce() {
    // leave here for legacy reasons
  },
};

pin.load();
