$('.textafter-icons *').click(function(){
  console.log($(this).data('icon'));

  $(this).toggleClass('active');
});
