const radclaim = {
  loaded: false,
  svg: draw.circle(0),
  aspectRatio: 1,

  draw(logofile = '/assets/radentscheid/claim.svg') {
    radclaim.svg.remove();
    
  
    radclaim.svg = draw.image(logofile, () => {
      radclaim.setAspectRatio(logofile);
      window.setTimeout(() => {
        
        radclaim.resize();
        radclaim.setPosition();
      }, 10);
    });
  },

  setSize(w) {
    radclaim.svg.size(w, w / radclaim.aspectRatio);
  },

  setPosition() {
    const x = draw.width() - radclaim.svg.width();
    const y = radclaim.svg.height() * 0.2;
    radclaim.svg.move(x, y);
  },

  setAspectRatio(logofile) {
    const image = new Image();
    image.src = logofile;
    log.ImageWidth= image.width;
    log.ImageHeight = image.height;
    radclaim.aspectRatio = image.width/image.height;
  },

  resize() {
    let percent = parseInt($('#logosize').val(), 10);
    percent = Math.min(100, percent);
    percent = Math.max(1, percent);

    const width = draw.width() * percent * 0.01;

    radclaim.svg.size(width, width / radclaim.aspectRatio);
  },
};


$('#logosize').bind('input propertychange', () => {
  radclaim.resize();
});

$('#logosize').bind('change', () => {
  undo.save();
});

$('.align-logo').click(function () {
  //console.log($(this).data('place'))
  
  const x = (draw.width() - radclaim.svg.width() * 1.1);
  const y = radclaim.svg.height() * 0.1;

  $('#logoX').val(x);
  $('#logoY').val(x);
  radclaim.svg.move(x, y);
  undo.save();
});
