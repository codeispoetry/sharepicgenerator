const eraser = {
  svg: draw.circle(0),
  backgroundClone: draw.circle(0),
  active: false,
  pointSize: 15,
  pointer: draw.circle(0).fill('black').opacity(0.5),

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

  drawAdd(x, y) {
    const v = $('#eraser').val();
    $('#eraser').val(`${v}${x},${y},${eraser.pointSize}|`);

    const circle = draw.circle(eraser.pointSize).move(x, y);
    eraser.svg.add(circle);
  },

  start() {
    config.noTextDradAndDrop = true;
    $('#btn-eraser').html('Radierer ausschalten');
    $('#btn-eraser').data('action', 'off');
    eraser.pointer.radius(eraser.pointSize / 2);
    eraser.draw();
    $('#canvas').css('cursor', 'none');

    draw.mousedown((e) => {
      eraser.active = true;
      const x = e.layerX;
      const y = e.layerY;
      eraser.drawAdd(x, y);
    });

    draw.mouseup(() => {
      eraser.active = false;
    });

    draw.mousemove((e) => {
      const x = e.layerX;
      const y = e.layerY;

      eraser.pointer.move(x, y).front();

      if (!eraser.active) {
        return false;
      }

      eraser.drawAdd(x, y);

      return true;
    });
  },

  stop() {
    config.noTextDradAndDrop = false;
    $('#btn-eraser').html('Radierer einschalten');
    $('#btn-eraser').data('action', 'on');
    $('#canvas').css('cursor', 'auto');

    draw.off();
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
