const radlogo = {
  loaded: false,
  svg: draw.circle(0),
  aspectRatio: 1,

  draw(logofile = '/assets/radentscheid/logo.svg') {
    radlogo.svg.remove();
    
  
    radlogo.svg = draw.image(logofile, () => {
      radlogo.setAspectRatio(logofile);
      window.setTimeout(() => {
        
        radlogo.resize();
        radlogo.setPosition();
      }, 10);
    });
  },

  setSize(w) {
    radlogo.svg.size(w, w / radlogo.aspectRatio);
  },

  setPosition() {
    const x = draw.width() - radlogo.svg.width();
    const y = draw.height() - radlogo.svg.height() * 1.2;
    radlogo.svg.move(x, y);
  },

  setAspectRatio(logofile) {
    const image = new Image();
    image.src = logofile;
    log.ImageWidth= image.width;
    log.ImageHeight = image.height;
    radlogo.aspectRatio = image.width/image.height;
  },

  resize() {
    let percent = parseInt($('#logosize').val(), 10);
    percent = Math.min(100, percent);
    percent = Math.max(1, percent);

    const width = draw.width() * percent * 0.01;

    radlogo.svg.size(width, width / radlogo.aspectRatio);
  },
};


$('#logosize').bind('input propertychange', () => {
  radlogo.resize();
});

$('#logosize').bind('change', () => {
  undo.save();
});

$('.align-logo').click(function () {
  //console.log($(this).data('place'))
  
  const x = (draw.width() - radlogo.svg.width() * 1.1);
  const y = radlogo.svg.height() * 0.1;

  $('#logoX').val(x);
  $('#logoY').val(x);
  radlogo.svg.move(x, y);
  undo.save();
});
