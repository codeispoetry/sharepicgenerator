$('.tipoftheday').bind('click', function tipoftheday() {
  $('.collapse').collapse('hide');
  const target = $(this).data('target');
  $(target).collapse('show');

  $(target).addClass('highlighted').delay(4000).queue(function deque() {
    $(this).removeClass('highlighted').dequeue();
  });

  $('.toast-tipoftheday').toast('hide');
});
