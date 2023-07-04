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

    hessenlogo.svg.move(x, 1.5 * y);
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

