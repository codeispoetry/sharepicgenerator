/* eslint-disable no-undef */

$(document).ready(() => {
  $('#advancedmode').bind('change', () => {
    $('.advancedmode').toggleClass('d-none', !$('#advancedmode').prop('checked'));
  });
});
