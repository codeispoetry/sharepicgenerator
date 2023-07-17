const banderole = {
  loaded: false,
  svg: draw.circle(0),
  font: {
    family: 'Capitolium',
    size: 16
  },
  
  draw() {
    banderole.svg.remove();
   
    const normHeight = 0.1 * draw.height();
    
    banderole.svg = draw.group();

    const banderoleRect = draw.rect(draw.width(), 1 * normHeight)
        .fill('#03523D');

    const size= 0.3 * normHeight;
    const textLeft = draw.text('Hessen lieben.').font(Object.assign(banderole.font, { size })).fill('#FFFFFF');
    const textRight = draw.text('Zukunft leben.').font(Object.assign(banderole.font, { size })).fill('#FFFFFF')
    
    const sunflower = draw.image('/assets/hessen/sunflower.svg', () => {
        sunflower.size(4 * normHeight, null)
          .move(0.5 * (draw.width() - sunflower.width()), 1 * - normHeight);

        const yTexts = 0.5 * (banderoleRect.height() - textLeft.bbox().h);
        textLeft.move(sunflower.x() - textLeft.bbox().w - (0 * normHeight), yTexts);
        textRight.move(sunflower.x() + sunflower.width() - (0 * normHeight), yTexts);

        banderole.svg.add(banderoleRect);
        banderole.svg.add(sunflower);
        banderole.svg.add(textLeft);
        banderole.svg.add(textRight);

        banderole.setPosition(banderoleRect.height() * 2.4);
    });

  },

  setPosition(y) {
    banderole.svg.y(draw.height() - y);
  },

  
};

