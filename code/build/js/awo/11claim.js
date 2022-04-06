const awoclaim = {
  svg: draw.text(''),

  draw() {
    awoclaim.svg.remove();

    awoclaim.svg = draw.text($('#awoclaim').val())
      .font({ family: 'Spray Letters', size: 20 })
      .move(20, 20)
      .fill($('#awoclaimcolor').val())
      .front();

    awoclaim.svg.filterWith((add) => {
      const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
      add.blend(add.$source, blur);
    });
  },
};

$('#awoclaim, #awoclaimcolor').bind('input propertychange', awoclaim.draw);

$(document).ready(() => {
  awoclaim.draw();
});
