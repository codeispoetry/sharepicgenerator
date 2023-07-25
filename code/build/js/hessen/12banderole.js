const banderole = {
  loaded: false,
  svg: draw.circle(0),
  font: {
    family: 'Capitolium',
    size: 16
  },
  
  draw(normHeight = 0.09 * draw.height()) {
    banderole.svg.remove();
    
    banderole.svg = draw.group();

    const banderoleRect = draw.rect(draw.width() * 0.5  - (1 * normHeight), 1 * normHeight)
        .fill('#03523D');
    const banderoleRect2 = draw.rect(draw.width() * 0.5 , 1 * normHeight)
        .fill('#03523D').dx(draw.width() * 0.5 + ( 1 * normHeight));

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
        banderole.svg.add(banderoleRect2);
        banderole.svg.add(sunflower);
        banderole.svg.add(textLeft);
        banderole.svg.add(textRight);

        banderole.setPosition(banderoleRect.height() * 2.25);
    });

  },

  setPosition(y) {
    banderole.svg.y(draw.height() - y);
  },
};

$('#sizepresets').on('change', function () {
  switch($(this).val()){
    case '1080:1920':
      banderole.draw(35);
      break;
    case '1500:2102':
    case '3531:4984':
    case '2492:3520':
    case '3520:4972':
    case '820:312':
      banderole.draw(45);
      break;
    default:
      banderole.draw(45);
      console.log($(this).val())
  }
});
