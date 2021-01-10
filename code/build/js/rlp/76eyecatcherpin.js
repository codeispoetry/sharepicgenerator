const pin = {
  isLoaded: false,
  file: '/assets/rlp/eyecatcher.svg',

  svg: draw.circle(0),

  load() {
    this.svg.remove();
    this.svg = draw.image(this.file, () => {
      this.isLoaded = true;
      this.draw();
    });
  },

  draw() {
    if (!pin.isLoaded) return false;
    pin.svg.size(draw.width() * $('#eyecatchersize').val() * 0.01, null);
    pin.svg.move(draw.width() - pin.svg.width() - 20, 20);
    return true;
  },

  bounce() {
    // void
  },
};

$('#pintext, #eyecatchersize').bind('input propertychange', pin.draw);
