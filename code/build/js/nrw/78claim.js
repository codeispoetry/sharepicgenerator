const claim = {
  isLoaded: false,
  svg: draw.circle(0),

  load(file = '/assets/nrw/claim.png') {
    claim.svg.remove();
    claim.svg = draw.image(file, (event) => {
      claim.isLoaded = true;
      claim.draw();
    });
  },

  draw() {
    if (!claim.isLoaded) return false;

    claim.svg.size(draw.width() * 0.51).move(0, draw.height() - claim.svg.height() - 20);
    claim.svg.front();
  },

  bounce() {
    // leave here for legacy reasons
  },
};

claim.load();
