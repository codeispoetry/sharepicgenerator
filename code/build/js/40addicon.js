const addPic99 = { ...addPic1 };
addPic99.i = 99;

$('#addPicSize99').bind('input propertychange', () => { addPic99.resize(); });
$('#addpicrounded99').bind('change', () => { addPic99.draw(); });
$('#addpicroundedbordered99').bind('change', () => { addPic99.draw(); });
$('#addpicdelete99').bind('click', () => { addPic99.delete(); });

// eslint-disable-next-line no-unused-vars
function setIcon(file) {
  // eslint-disable-next-line no-param-reassign
  file = `../../tenants/frankfurt/${file}`;
  $('#addpicfile99').val(file);
  show('show-add-pic-99');
  show('show-add-pic-upload');
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();

  if ($('#addPic99x').val() === '') {
    const widthPercent = 36;
    const widthAbsolute = (draw.width() * widthPercent) * 0.01;

    $('#addPic99x').val(draw.width() - widthAbsolute);
    $('#addPic99y').val(draw.height() - widthAbsolute);
    $('#addPicSize99').val(widthPercent);
  }

  addPic99.draw();
}

function rePositionIcon() {
  const file = $('#addpicfile99').val();
  $('#addPic99x').val('');
  setIcon(file);
}
