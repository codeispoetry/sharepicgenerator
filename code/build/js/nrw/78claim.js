const claim = {
  isLoaded: false,
  svg: draw.circle(0),

  load(file = '/assets/nrw/claim.png') {
    claim.svg.remove();
    claim.svg = draw.image(file, () => {
      claim.isLoaded = true;
      claim.draw();
    });
  },

  draw() {
    if (!claim.isLoaded) return false;

    const claimHeight = (draw.width() * 0.51) / (1280 / 102);

    claim.svg.size(draw.width() * 0.51, claimHeight)
      .move(0, draw.height() - claim.svg.height() - 20);
    claim.svg.front();
    return true;
  },

  bounce() {
    // leave here for legacy reasons
  },
};

claim.load();
