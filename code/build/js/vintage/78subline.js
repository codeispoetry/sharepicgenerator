const subline = {

  svg: draw.circle(0),

  draw() {
    subline.svg.remove();
    const color = $('#claimColor').val();
    subline.svg = draw.text('DIE\nGRÜNEN').fill(color).move(15, draw.height() - 195).font(
      {
        family: 'RockoUltraFLFBold',
        size: 80,
        leading: '1em',
        weight: 'bold',
        anchor: 'left',
      },
    );
  },
};
