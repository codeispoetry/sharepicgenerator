const claim = {
  svg: draw.circle(0),

  draw() {
    claim.svg.remove();
    const color = $('#claimColor').val();

    claim.svg = draw.text('ökologisch · sozial · basisdemokratisch · gewaltfrei').fill(color).move(19, draw.height() - 30).font(
      {
        family: 'RockoUltraFLF',
        size: 22,
        anchor: 'left',
        weight: 'normal',
      },
    );
  },
};
claim.draw();

const claimColors = ['white', 'black', '#46962b', '#E6007E', '#FEEE00'];
let claimColorIndex = 0;

$('.claim-change-color').click(() => {
  claimColorIndex++;
  claimColorIndex %= claimColors.length;
  $('#claimColor').val(claimColors[claimColorIndex]);
  claim.draw();
  subline.draw();
});
