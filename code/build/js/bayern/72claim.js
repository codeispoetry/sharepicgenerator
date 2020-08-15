const claim = {
  svg: draw.circle(0),

  draw() {
    claim.svg.remove();
    const color = $('#claimColor').val();
    claim.svg = draw.text($('#claim').val().toUpperCase()).fill(color).move(15, 16).font(
      {
        family: 'ArvoGruen',
        size: 18,
        anchor: 'left',
        weight: 300,
      },
    );
  },
};
claim.draw();

$('#claim').bind('input propertychange', claim.draw);

const claimColors = ['white', 'black', '#46962b', '#E6007E', '#FEEE00'];
let claimColorIndex = 0;

$('.claim-change-color').click(() => {
  claimColorIndex++;
  claimColorIndex %= claimColors.length;
  $('#claimColor').val(claimColors[claimColorIndex]);
  claim.draw();
});
