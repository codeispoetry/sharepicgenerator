$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pin = {
  isLoaded: false,
  svg: draw.circle(0),

  load(file = '/assets/nrw/eyecatcher.svg') {
    pin.svg.remove();
    pin.svg = draw.image(file, () => {
      pin.isLoaded = true;

      pin.draw();
    });
  },

  draw() {
    if (!pin.isLoaded) return false;

    const offsetLeft = -154 / 948;
    const pinMoveX = offsetLeft * pin.svg.width();
    const pinMoveY = draw.height() - pin.svg.height() - 70;
    pin.svg.size(draw.width() * 0.33).move(pinMoveX, pinMoveY);
    pin.svg.front();
    return true;
  },

  bounce() {
    // leave here for legacy reasons
  },
};

pin.load();
