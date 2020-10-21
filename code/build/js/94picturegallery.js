$('.galleryPicture').click(function galleryImgClick() {
  $('#pictureoverlay').hide();
  uploadFileByUrl(`../tenants/${config.tenant}/${$(this).data('url')}`, () => {
    if (typeof reDraw === 'function') {
    // eslint-disable-next-line no-undef
      reDraw(false);
    }

    $('#canvas-area').slideDown();
    $('#waiting').hide();
  });
});
