const hessenlogo = {
  loaded: false,
  svg: draw.circle(0),

  draw(logofile = $('#logofile').val()) {
    hessenlogo.svg.remove();
    if(logofile == '' || logofile == undefined) {
      logofile = config.hessenlogo;
    }
    
    hessenlogo.svg = draw.image(logofile, () => {

      hessenlogo.resize();
      hessenlogo.setPosition();
    });

  },

  setSize(w) {
    hessenlogo.svg.size(w, w);
  },

  setPosition() {
    const x = 0.5 * (draw.width() - hessenlogo.svg.width() );
    const y = hessenlogo.svg.height();
    console.log('yx: ' + x  + "/" + y);
    hessenlogo.svg.move(x, 0);
  },

  resize() {
    // let percent = parseInt($('#logosize').val(), 10);
    // percent = Math.min(100, percent);
    // percent = Math.max(1, percent);

    // const width = draw.width() * percent * 0.01;
    const width = draw.width() * 208 / 1080;
    hessenlogo.svg.size(width, width);
  },

  adjustToFrame() {
    const frame = $('#framewidth').val();
    const width = (frame / 130)  * draw.width() * 208 / 1080;
    hessenlogo.svg.size(width, width);

    const pos = hessenlogo.getPostionValues();
 
    $('#logoX').val(pos.x);
    $('#logoY').val(pos.y);
    hessenlogo.setPosition();
  },

  getPostionValues() {
    let x, y;
    switch($('#logoPosition').val()) {
      case 'topright':
          x = draw.width() - hessenlogo.svg.width() * 1.2;
          y = hessenlogo.svg.height() * 0.2;
          break;
      case 'bottomright':
          x = draw.width() - hessenlogo.svg.width() * 1.2;
          y = draw.height() - hessenlogo.svg.height() * 1.2;
          break;
      default:
          x = 0;
          y = 0;
    }

    return {x, y};
  }
};

$('#logosize').bind('input propertychange', () => {
  hessenlogo.resize();
});

$('#logosize').bind('change', () => {
  undo.save();
});

$('.align-logo').click(function () {
  let x, y;
  const place = $(this).data('place');
  $('#logoPosition').val(place);
  const pos = hessenlogo.getPostionValues();
  x = pos.x;
  y = pos.y;

  $('#logoX').val(x);
  $('#logoY').val(y);

  hessenlogo.svg.move(x, y);
  undo.save();
});
