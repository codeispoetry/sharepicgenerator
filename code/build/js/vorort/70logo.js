const logo = {
  loaded: false,
  svg: draw.image('/assets/vorort/logo.png', () => {
    logo.loaded = true;
  }),

  draw() {
    logo.svg
      .move(100,100)
  
  },

  setPosition(){
    logo.svg.size(null, draw.height() * 0.35);
;

    logo.svg.move(draw.width() * 0.1, draw.height() * 0.2);
  },

  setSize(){

  }

};


