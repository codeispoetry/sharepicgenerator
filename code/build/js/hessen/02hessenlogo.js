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

  setPosition() {
    const x = 0.5 * (draw.width() - hessenlogo.svg.width() );
    const y = hessenlogo.svg.height();
    let marginToTop = 1.5 * y;

    if(draw.width() > draw.height()) {
      marginToTop = 0.6 * y;
    }

    hessenlogo.svg.move(x, marginToTop);
  },

  resize() {
    // let percent = parseInt($('#logosize').val(), 10);
    // percent = Math.min(100, percent);
    // percent = Math.max(1, percent);

    // const width = draw.width() * percent * 0.01;
    const width = draw.width() * 0.2;
    const ratio = 1090 / 195
    hessenlogo.svg.size(width, width /  ratio);
  },
};

$('#hessen-logo-green').click(() => {
  const logofile = ( $('#hessen-logo-green').is(':checked') ) ? '/assets/hessen/logo-green.svg' : '/assets/hessen/logo.svg';
  hessenlogo.draw(logofile);
});

$('#hessen-logo-show').click(() => {
  if( $('#hessen-logo-show').is(':checked') ) {
    hessenlogo.svg.show();
  } else {
    hessenlogo.svg.hide();
  }

});
