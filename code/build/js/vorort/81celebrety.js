const celebrety = {
  loaded: false,
  svg: draw.image('/assets/vorort/lucha.png', () => {
    celebrety.loaded = true;
  }),


  setPosition(){
    celebrety.svg.size(null, draw.height() * 0.7);

    const w =  celebrety.svg.width();
    const h =  celebrety.svg.height();

    celebrety.svg.move(draw.width() - w, draw.height() - h);
  },


};


