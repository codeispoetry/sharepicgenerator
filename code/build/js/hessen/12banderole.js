const banderole = {
  loaded: false,
  svg: draw.circle(0),

  draw() {
    banderole.svg.remove();
   
    
    banderole.svg = draw.group();

    const banderoleRect = draw.rect(draw.width(), 0.05 * draw.height())
        .fill('#03523D')
        .dy(0.05 * draw.height());

    const textLeft = draw.text('Hessen lieben.').font({
        family: 'Capitolium'
    }).fill('#FFFFFF');

    const textRight = draw.text('Zukunft leben.').font({
        family: 'Capitolium'
    }).fill('#FFFFFF')
    
    const sunflower = draw.image('/assets/hessen/sunflower.svg', () => {
        sunflower.size(draw.width() * 0.35, null).move(0.5 * (draw.width() - sunflower.width()), 0);

        const yTexts = 36;
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
    banderole.svg.move(0,draw.height() - ( 0.48 * banderole.svg.height() ));
  },

  
};

