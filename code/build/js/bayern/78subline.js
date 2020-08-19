const subline = {

  svg: draw.circle(0),

  draw() {
    subline.svg.remove();
    const color = $('#sublineColor').val();
    subline.svg = draw.text($('#subline').val().toUpperCase()).fill(color).move(15, draw.height() - 36).font(
      {
        family: 'ArvoGruen',
        size: 18,
        anchor: 'left',
        weight: 300,
      },
    );
  },
};

$('#subline').bind('input propertychange', subline.draw);

const sublineColors = ['white', 'black', '#46962b', '#E6007E', '#FEEE00'];
let sublineColorIndex = 0;

$('.subline-change-color').click(() => {
  sublineColorIndex += 1;
  sublineColorIndex %= sublineColors.length;
  $('#sublineColor').val(sublineColors[sublineColorIndex]);
  subline.draw();
});
