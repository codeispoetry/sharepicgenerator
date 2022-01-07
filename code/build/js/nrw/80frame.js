const frame = {
  svg: draw.text(''),
  draw() {
    frame.svg.remove();
    const width = $('#framewidth').val();
    const right = draw.width();
    const bottom = draw.height();

    const stripe = 80; // width of stripe

    const pattern = draw.pattern((54 / 3) * stripe, 4 * stripe, function(add) {
      let color1;
      let color2;
      switch ($('#framecolor').val()) {
        case '#33582d':
          color1 = '#33582d';
          color2 = '#516f30';
          break;
        case '#b7398e':
          color1 = '#b7398e';
          color2 = '#c0569e';
          break;
        default:
          color1 = '#b9ce1d';
          color2 = '#96b126';
      }

      add.rect(60 * stripe,stripe).move(-15 * stripe, 0).fill(color1);
      add.rect(60 * stripe,2 * stripe).move(-15 * stripe, stripe).fill(color2);
      add.rect(60 * stripe,stripe).move(-15 * stripe, 3 * stripe).fill(color1);
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

$('#framewidth').bind('input propertychange', () => {
  frame.draw();
});

window.setTimeout(() => {
  $('#framecolorpicker .dot').click(() => {
    $('#frame').prop('checked', true);
  });
}, 2000);
