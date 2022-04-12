const awoclaim = {
  svg: draw.text(''),
  background: draw.circle(0),

  draw() {
    awoclaim.svg.remove();
    awoclaim.background.remove();

    awoclaim.svg = draw.group();

    const text = draw.text($('#awoclaim').val())
      .font(
        {
          family: 'PTSans',
          size: 20,
          leading: '0.95em',
          weight: 'bold',
        },
      )
      .fill($('#awoclaimcolor').val())
      .front();

    // not in group
    awoclaim.background = draw.rect(draw.width(), 200)
      .fill('white')
      .move(0, draw.height() - 110)
      .opacity(0.7);

    awoclaim.svg.add(text);

    awoclaim.setPosition();

    awoclaim.svg.front();
    logo.svg.front();
    copyright.svg.front();

    // awoclaim.svg.filterWith((add) => {
    //   const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
    //   add.blend(add.$source, blur);
    // });
  },

  setPosition() {
    awoclaim.svg.move(140, draw.height() - 90);
  },
};

$('#awoclaim, #awoclaimcolor').bind('input propertychange', awoclaim.draw);

$(document).ready(() => {
  awoclaim.draw();
});
