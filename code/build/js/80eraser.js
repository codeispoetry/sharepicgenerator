const eraser = {
  svg: draw.circle(0),
  backgroundClone: draw.circle(0),

  draw() {
    eraser.svg.remove();
    eraser.backgroundClone.remove();

    eraser.backgroundClone = background.svg.clone();
    draw.add(eraser.backgroundClone);

    eraser.svg = draw.clip();

    const values = $('#eraser').val().split('|');
    values.forEach((value) => {
      if (value === '') {
        return true;
      }
      const circleValues = value.split(',');
      const radius = parseInt(circleValues[2], 10);
      const circle1 = draw.circle(radius)
        .move(
          parseInt(circleValues[0], 10) - radius / 2, parseInt(circleValues[1], 10) - radius / 2
        )
        .fill('black');
      eraser.svg.add(circle1);
      return true;
    });

    eraser.backgroundClone.clipWith(eraser.svg);
  },

  start() {
    config.noTextDradAndDrop = true;
    $('#btn-eraser').html('Radierer ausschalten');
    $('#btn-eraser').data('action', 'off');

    draw.click((e) => {
      const v = $('#eraser').val();
      const pointSize = 15;
      $('#eraser').val(`${v}${e.layerX},${e.layerY},${pointSize}|`);
      eraser.draw();
    });
  },

  stop() {
    config.noTextDradAndDrop = false;
    $('#btn-eraser').html('Radierer einschalten');
    $('#btn-eraser').data('action', 'on');

    draw.off('click');
  },

};

$('#btn-eraser').click(() => {
  if ($('#btn-eraser').data('action') === 'on') {
    eraser.start();
  } else {
    eraser.stop();
  }
});

$('#eraser-delete').click(() => {
  $('#eraser').val('');
  eraser.draw();
});
