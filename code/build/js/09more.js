$(document).ready(() => {
  $('.expertmode').addClass('d-none');

  $('.btn-more').click(function showExpert() {
    $('.expertmode').toggleClass('d-none');
    $('span', this).toggleClass('d-none');
  });
});
