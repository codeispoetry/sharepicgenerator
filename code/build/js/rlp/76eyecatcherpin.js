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

    if ($('#pinPosition').val() === 'left') {
      pin.svg.move(20, 20);
    } else {
      pin.svg.move(draw.width() - pin.svg.width() - 20, 20);
    }

    return true;
  },

  bounce() {
    // void
  },

  toleft() {
    $('#pinPosition').val('left');
    pin.draw();
  },

  toright() {
    $('#pinPosition').val('right');
    pin.draw();
  },
};

$('#pintext, #eyecatchersize').bind('input propertychange', pin.draw);

$('.pintoleft').bind('click', pin.toleft);
$('.pintoright').bind('click', pin.toright);
