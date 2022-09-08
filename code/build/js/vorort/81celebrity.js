const celebrity = {
  loaded: false,
  svg: draw.image('/assets/vorort/sunflower.png', () => {
    celebrity.loaded = true;
  }),

  set(){
    celebrity.loaded = false;
    who = $('#celebrity option:selected').val();

    celebrity.svg.remove();
    celebrity.svg = draw.image(`/assets/vorort/celebrities/${who}`, () => {
      celebrity.loaded = true;
      celebrity.setPosition();
    });

    $('#text1').val($('#celebrity option:selected').data('desc').replace(/\|/,'\n'));
    alltexts.draw();

    arrangeLayers();
  },

  setPosition(){
    celebrity.svg.size(null, draw.height() * 0.7);

    const w =  celebrity.svg.width();
    const h =  celebrity.svg.height();

    celebrity.svg.move(draw.width() - w, draw.height() - h);
  },

};

$('#celebrity').bind('change', celebrity.set);

