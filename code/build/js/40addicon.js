// eslint-disable-next-line no-unused-vars
function setIcon(file) {
  $('#addpicfile1').val(file);
  show('show-add-pic-1');
  show('show-copyright');
  show('show-add-pic-upload');
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
  addPic1.draw();
}
