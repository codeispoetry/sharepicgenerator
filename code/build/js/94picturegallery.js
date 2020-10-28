$('.galleryPicture').click(function galleryImgClick() {
  $('#pictureoverlay').hide();

  setIcon($(this).data('url'));
  $('#canvas-area').slideDown();
  $('#waiting').hide();
  return true;

  uploadFileByUrl(`../tenants/${config.tenant}/${$(this).data('url')}`, () => {
    if (typeof reDraw === 'function') {
    // eslint-disable-next-line no-undef
      reDraw(false);
    }

    $('#canvas-area').slideDown();
    $('#waiting').hide();
  });
});
