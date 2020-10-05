// eslint-disable-next-line no-unused-vars
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bg_small.jpg',
  fullBackgroundName: '../assets/bg.jpg',
};

$(document).ready(() => {
  //$('#text').val('Es beginnt\n[#mitdir]');
  $('#textsize').val(407);
  $('#textX').val(35);
  $('#textY').val(181);
  config.layout = 'nolines';

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  $('.toast').toast({ delay: 10000 });
  $('.toast-actionday').toast('show');

  showLayout();
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
    nolines.draw();
    pin.draw();
  }, 10);

  window.setTimeout(() => {
    copyright.draw();
    icon.load();
    logo.load();
  }, 20);

  window.setTimeout(() => {
    logo.load();
    nolines.draw();
  }, 100);
}
