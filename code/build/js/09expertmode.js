/* eslint-disable no-undef */
$(document).ready(() => {
  if (config.user.prefs.expertMode) {
    $('#expertmode').bootstrapToggle('on');
    $('.expertmode').removeClass('d-none');
  } else {
    $('#expertmode').bootstrapToggle('off');
    $('.expertmode').addClass('d-none');
  }

  $('#expertmode').bind('change', () => {
    $('.expertmode').toggleClass('d-none');
    config.user.prefs.expertMode = !$('.expertmode').hasClass('d-none');
    setUserPrefs();
  });
});
