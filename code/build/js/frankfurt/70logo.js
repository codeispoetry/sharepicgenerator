const logo = {
  heightFraction: 0.08,
  sunflowerFraction: 0.15,
  logoRect: draw.circle(0),
  logoFile: draw.circle(0),

  draw: () => {
    logo.logoRect.remove();
    logo.logoFile.remove();

    let color = '#46962b';
    if (config.logoBlack) {
      color = '#000000';
    }

    logo.logoRect = draw.rect(draw.width(), draw.height() * logo.heightFraction)
      .fill(color)
      .opacity(0.85)
      .move(0, draw.height() - draw.height() * logo.heightFraction);

    const size = draw.height() * logo.sunflowerFraction;

    logo.logoFile = draw.image('/assets/logos/sonnenblume.svg', () => {
      logo.logoFile.size(size)
        .move(size * 0.5, draw.height() - draw.height() * logo.heightFraction - size * 0.73);

      if ($('#sizepresets').val() === '1080:1920') {
        logo.logoFile.x(20);
      }
    });
  },

};
