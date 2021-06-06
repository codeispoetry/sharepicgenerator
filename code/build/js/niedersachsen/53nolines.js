/* eslint-disable no-undef */
const nolines = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ffffff', '#ffee00'],
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  claim: draw.image('/assets/nds_claim.png'),
  font: {
    family: 'BereitBold',
    anchor: 'left',
    leading: '1.2em',
    size: 55,
  },

  drawClaim() {
    nolines.claim.front().size(280).move(20, draw.height() - 60);
  },

  draw() {
    if (config.layout !== 'nolines') {
      return;
    }

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    const innertext = draw.text($('#text').val())
      .fill('#ffffff')
      .font(Object.assign(nolines.font));

    text.svg.add(innertext);

    eraser.front();
    showActionDayHint();

    // gray layer behind text
    text.grayBackground.remove();

    text.grayBackground = draw.rect(draw.width(), text.svg.height() + 120)
      .y(draw.height() - text.svg.height() - 85)
      .fill('#a0c865')
      .back();
    background.svg.back();

    logo.svg.size(draw.width() * 0.26);
    logo.svg.move(draw.width() * 0.705, text.grayBackground.y() - (logo.svg.height() * 0.84));

    text.svg.move(20, draw.height() - text.svg.height() - 75);

    checkForOtherTenant();
  },

};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext').bind('input propertychange', nolines.draw);
