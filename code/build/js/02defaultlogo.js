const defaultlogo = {
  loaded: false,
  svg: draw.circle(0),

  draw(logofile = $('#logofile').val()) {
    defaultlogo.svg.remove();
    if(logofile == '' || logofile == undefined) {
      logofile = config.defaultlogo;
    }
    defaultlogo.svg = draw.image(logofile, () => {

      defaultlogo.svg.addClass('draggable').draggable();
      defaultlogo.setPosition();
      defaultlogo.resize();

      defaultlogo.svg.on('dragstart.namespace', function () {
        undo.save();
      });
      defaultlogo.svg.on('dragend.namespace', function logoDragEnd() {
        $('#logoX').val(Math.round(this.x()));
        $('#logoY').val(Math.round(this.y()));
      });
    });
  },

  setSize(w) {
    defaultlogo.svg.size(w, null);
  },

  setPosition() {
    const x = parseInt($('#logoX').val(), 10);
    const y = parseInt($('#logoY').val(), 10);
    defaultlogo.svg.move(x, y);
  },

  resize() {
    let percent = parseInt($('#logosize').val(), 10);
    percent = Math.min(100, percent);
    percent = Math.max(1, percent);

    const width = draw.width() * percent * 0.01;
    defaultlogo.svg.size(width, null);
  },
};

$('#logosize').bind('input propertychange', () => {
  defaultlogo.resize();
});

$('#logosize').bind('change', () => {
  undo.save();
});

$('.align-logo').click(function () {
  //console.log($(this).data('place'))
  
  const x = (draw.width() - defaultlogo.svg.width() * 1.1);
  const y = defaultlogo.svg.height() * 0.1;

  $('#logoX').val(x);
  $('#logoY').val(x);
  defaultlogo.svg.move(x, y);
  undo.save();
});
