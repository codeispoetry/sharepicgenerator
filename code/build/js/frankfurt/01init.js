/* eslint-disable no-undef */
// eslint-disable-next-line no-unused-vars
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/white_small.jpg',
  fullBackgroundName: '../assets/white.jpg',
};

$(document).ready(() => {
  $('#text').val('Hier ist\nFrankfurt');
  $('#textsize').val(502);
  $('#textX').val(41);
  $('#textY').val(122);
  config.layout = 'nolines';

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

 

  $('#addtextX').val(50);
  $('#addtextY').val(draw.height() - 50);

  showLayout();

  $(".galleryPicture[data-url!='pictures/img/frankfurt/090_Gruene-Icon_11-Trauer.png']").click(() => {
    config.logoBlack = false;
    logo.draw();
  });
  $(".galleryPicture[data-url='pictures/img/frankfurt/090_Gruene-Icon_11-Trauer.png']").click(() => {
    config.logoBlack = true;
    logo.draw();
  });
});

// eslint-disable-next-line no-unused-vars
function reset() {
  // do nothing, stay here
}

// eslint-disable-next-line no-unused-vars
function reDraw(withAddPic = false) {
  if (withAddPic === true) {
    addPic1.draw();
    addPic2.draw();
  }

  window.setTimeout(() => {
    pin.draw();
  }, 10);

  window.setTimeout(() => {
    icon.load();
  }, 20);

  window.setTimeout(() => {
    text.draw();
    addtext.draw();
    quote.draw();
    nolines.draw();
    invers.draw();
    eraser.draw();
    rePositionIcon();
  }, 100);

  window.setTimeout(() => {
    logo.draw();
  }, 200);

  if ($('#backgroundFlipped').val() === 'true') {
    $('#backgroundflip').click();
  }
}

function initSharepic() {
  // void
}
