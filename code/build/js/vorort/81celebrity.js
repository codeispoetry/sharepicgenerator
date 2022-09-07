const celebrity = {
  loaded: false,
  svg: draw.image('/assets/vorort/lucha.png', () => {
    celebrity.loaded = true;
  }),

  set(){
    celebrity.loaded = false;
    who = $('input[name=celebrity]:checked').val();

    celebrity.svg.remove();
    celebrity.svg = draw.image(`/assets/vorort/${who}.png`, () => {
      celebrity.loaded = true;
      celebrity.setPosition();
    });

    $('#text1').val($('input[name=celebrity]:checked').data('desc').replace(/\|/,'\n'));
    alltexts.draw();
  },

  setPosition(){
    celebrity.svg.size(null, draw.height() * 0.7);

    const w =  celebrity.svg.width();
    const h =  celebrity.svg.height();

    celebrity.svg.move(draw.width() - w, draw.height() - h);
  },

};

$('.celebrity').bind('click', celebrity.set);

