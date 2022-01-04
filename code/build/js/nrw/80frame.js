const frame = {
  svg: draw.text(''),
  draw() {
    frame.svg.remove();
    const width = 50;
    const right = draw.width();
    const bottom = draw.height();

    const stripe = 80; // width of stripe

    const pattern = draw.pattern((54 / 3) * stripe, 4 * stripe, function(add) {
      add.rect(60 * stripe,stripe).move(-15 * stripe, 0).fill('#b9ce1d');
      add.rect(60 * stripe,2 * stripe).move(-15 * stripe, stripe).fill('#96b126');
      add.rect(60 * stripe,stripe).move(-15 * stripe, 3 * stripe).fill('#b9ce1d');
    });
    pattern.rotate(-35);

    frame.svg = draw.polygon(`0,0 ${right},0 ${right},${bottom} 0,${bottom}, 0,${width}, 
      ${width},${width} ${width},${bottom - width} ${right - width},${bottom - width} ${right - width},${width} 0, ${width}
      `).fill(pattern);

    logo.svg.front();
    floating.svg.front();
    pin.svg.front();
  },
};

$('#frame').click(() => {
  if ($('#frame').is(':checked')){
    frame.draw();
  } else {
    frame.svg.remove();
  }
});
