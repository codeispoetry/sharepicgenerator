/* eslint-disable no-undef */
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/vorort/bg_vorort_small.jpg',
  fullBackgroundName: '../assets/vorort/bg_vorort.jpg',
};

var initialized = false;

$(document).ready(() => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  defaultlogo.svg.remove();
  reDraw();

  $('.close-target').click(function doCloseTarget() {
    $($(this).data('target')).slideUp();
  });
});

function initSharepic() {
  if (initialized) {
    return false;
  }
  // called after background pic is loaded
  $('#sizepresets').val('1080:1080').trigger('change');
  initialized = true;

  background.drawShadow();
  return true;
}

function reset() {
  // do nothing, stay here

}

function reDraw(withAddPic = false) {
  window.setTimeout(() => {

    background.drawShadow();
    celebrity.setPosition();
    logo.setPosition();
    alltexts.draw();
  }, 100);
}

function arrangeLayers(){
  background.svg.back();
  background.shadow.front();
  celebrity.svg.front();
  logo.svg.front();
  alltexts.svg1.front();
  alltexts.svg2.front();
  alltexts.svg3.front();
  alltexts.svg4.front();
  alltexts.svg5.front();

}
