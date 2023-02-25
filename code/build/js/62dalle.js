function generateImage() {
    $.ajax({
      type: 'POST',
      url: '/actions/dalle.php',
      data: {
        prompt: JSON.stringify($('#ai-image-prompt').val()),
        csrf: config.csrf,
      },
      success(response) {
        if( response.length == 0 ) {
            return;
        }
       
        json = JSON.parse(response);
        if(json.length == 0 ) { 
            return;
        }

        console.log("parsed:",response)
        uploadFileByUrl(json.url);

        $('ai-image-trigger').removeClass('active');
       },
      error(response) {
        console.log(response);
      },
    });
}

$('.ai-image-trigger').click(function() {
  if($(this).hasClass('active')) {
    return;
  }
  $(this).addClass('active');
  generateImage();
});


