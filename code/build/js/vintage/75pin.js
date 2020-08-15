$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

$('#pintofront').click(() => {
  pin.svg.front();
});

const pin = {
  isLoaded: false,

  svg: draw.rect(0, 0),

  draw() {
    return false;
  },

  bounce() {
    return false;
  },
};
