const bayernlogo = {
  loaded: false,
  svg: draw.circle(0),

  draw(logofile = $('#logofile').val()) {
    bayernlogo.svg.remove();
    if(logofile == '' || logofile == undefined) {
      logofile = config.bayernlogo;
    }
    
    bayernlogo.svg = draw.image(logofile, () => {

      bayernlogo.svg.addClass('draggable').draggable();
      bayernlogo.setPosition();
      bayernlogo.resize();

      bayernlogo.svg.on('dragstart.namespace', function () {
        undo.save();
      });
      bayernlogo.svg.on('dragend.namespace', function logoDragEnd() {
        $('#logoX').val(Math.round(this.x()));
        $('#logoY').val(Math.round(this.y()));
      });

      $('.align-logo:nth-child(1)').click();
    });
  },

  setSize(w) {
    bayernlogo.svg.size(w, null);
  },

  setPosition() {
    const x = parseInt($('#logoX').val(), 10);
    const y = parseInt($('#logoY').val(), 10);
    bayernlogo.svg.move(x, y);
  },

  resize() {
    // let percent = parseInt($('#logosize').val(), 10);
    // percent = Math.min(100, percent);
    // percent = Math.max(1, percent);

    // const width = draw.width() * percent * 0.01;
    const width = draw.width() * 208 / 1080;
    bayernlogo.svg.size(width, width);
  },
};

$('#logosize').bind('input propertychange', () => {
  bayernlogo.resize();
});

$('#logosize').bind('change', () => {
  undo.save();
});

$('.align-logo').click(function () {
  
  let x, y;
  switch($(this).data('place')) {
    case 'topright':
        x = draw.width() - bayernlogo.svg.width() * 1.2;
        y = bayernlogo.svg.height() * 0.2;
        break;
    case 'bottomright':
        x = draw.width() - bayernlogo.svg.width() * 1.2;
        y = draw.height() - bayernlogo.svg.height() * 1.2;
        break;
    default:
        x = 0;
        y = 0;
  }

  $('#logoX').val(x);
  $('#logoY').val(x);


  bayernlogo.svg.move(x, y);
  undo.save();
});
