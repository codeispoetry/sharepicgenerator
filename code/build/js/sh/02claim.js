const claim = {
  loaded: false,
  svg: draw.circle(0),

  draw() {
    claim.svg.remove();
    const logofile = '/assets/sh/claim.svg'
    claim.svg = draw.image(logofile, () => {

      claim.svg.addClass('draggable').draggable();
      claim.setPosition();
      claim.resize();

      claim.svg.on('dragstart.namespace', function () {
        undo.save();
      });
      claim.svg.on('dragend.namespace', function logoDragEnd() {
        $('#claimX').val(Math.round(this.x()));
        $('#claimY').val(Math.round(this.y()));
      });
    });
  },

  setSize(w) {
    claim.svg.size(w, null);
  },

  setPosition() {
    const x = parseInt($('#claimX').val(), 10);
    const y = parseInt($('#claimY').val(), 10);
    claim.svg.move(x, y);
  },

  resize() {
    let percent = parseInt($('#logosize').val(), 10);
    percent *= 0.6;
    percent = Math.min(100, percent);
    percent = Math.max(1, percent);

    const width = draw.width() * percent * 0.01;
    claim.svg.size(width, width);
  },
};

$('#logosize').bind('input propertychange', () => {
  claim.resize();
});

$('#logosize').bind('change', () => {
  undo.save();
});

$('.align-logo').click(function () {
  //console.log($(this).data('place'))
  
  const x = (draw.width() - claim.svg.width() * 1.1);
  const y = claim.svg.height() * 0.1;

  $('#claimX').val(x);
  $('#claimY').val(x);
  claim.svg.move(x, y);
  undo.save();
});
