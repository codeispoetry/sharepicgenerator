const banderole = {
  loaded: false,
  svg: draw.circle(0),
  font: {
    family: 'Capitolium',
    size: 16
  },
  
  draw() {
    banderole.svg.remove();
   
    const normHeight = 0.05 * draw.height();
    
    banderole.svg = draw.group();

    const banderoleRect = draw.rect(draw.width(), normHeight)
        .fill('#03523D');

    const size= 0.5 * normHeight;
    const textLeft = draw.text('Hessen lieben.').font(Object.assign(banderole.font, { size })).fill('#FFFFFF');
    const textRight = draw.text('Zukunft leben.').font(Object.assign(banderole.font, { size })).fill('#FFFFFF')
    
    const sunflower = draw.image('/assets/hessen/sunflower.svg', () => {
        sunflower.size(7 * normHeight, null)
          .move(0.5 * (draw.width() - sunflower.width()), 2 * -normHeight);

        const yTexts = 0.5 * ( normHeight - textLeft.bbox().h);
        textLeft.move(sunflower.x() - textLeft.bbox().w, yTexts);
        textRight.move(sunflower.x() + sunflower.width(), yTexts);

        banderole.svg.add(banderoleRect);
        banderole.svg.add(sunflower);
        banderole.svg.add(textLeft);
        banderole.svg.add(textRight);

        banderole.setPosition();
    });

  },

  setPosition() {
    banderole.svg.move(0,draw.height() - ( 3.5 * 0.05 * draw.height() ));
  },

  
};

