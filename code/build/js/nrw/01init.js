// eslint-disable-next-line no-unused-vars
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/nrw/wiese_small.jpg',
};

$(document).ready(() => {
  $('#text').val('!Grün ist\ndie Zukunft.');
  $('#textX').val(500);
});

// eslint-disable-next-line no-unused-vars
function reset() {
  // do nothing, stay here
  if (pin !== undefined) {
    pin.draw();
    claim.draw();
  }
}

function reDraw() {
  addPic1.draw();
  addPic2.draw();
  logo.load();

  window.setTimeout(() => {
    text.draw();
    subText.draw();
    pin.draw();
  }, 10);

  window.setTimeout(() => {
    copyright.draw();
    icon.load();
  }, 20);
}
