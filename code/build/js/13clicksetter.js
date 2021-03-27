$(document).ready(() => {
  $('.click-setter').click(function setClickSetter() {
    const value = $(this).data('value');
    const field = $(this).data('field');
    const action = $(this).data('action');

    $(field).val(value);

    // eslint-disable-next-line no-eval
    eval(action);
  });
});
