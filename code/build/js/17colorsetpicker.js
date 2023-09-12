$(document).ready(() => {
  $('.colorSetPicker .dot').click(function () {
    if($(this).hasClass('disabled')){
      return;
    } 


    const i = $(this).data('i');
    $('#lineColorSet' + i).val($(this).data('colorset'));
    detext.draw();
  });
});
