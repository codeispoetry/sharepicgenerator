/* eslint-disable no-undef */
$(document).ready(() => {
  $('.toast').toast({ delay: 10000 });

  if (config.user.prefs.seenActionDay !== $('.toast-actionday').data('id')) {
    $('.toast-actionday').toast('show');
    config.user.prefs.seenActionDay = $('.toast-actionday').data('id');
    setUserPrefs();
  }

  if (config.user.prefs.seenTipOfTheDay !== $('.toast-tipoftheday').data('id')) {
    $('.toast-tipoftheday').toast('show');
    config.user.prefs.seenTipOfTheDay = $('.toast-tipoftheday').data('id');
    setUserPrefs();
  }
});
