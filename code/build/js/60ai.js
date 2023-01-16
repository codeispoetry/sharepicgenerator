function askAI() {
    if ( $('#text').val().length < 10 ) {
        return;
    }

    if ( localStorage.getItem('askedAI') == 1 ) {
        return;
    }
   
    localStorage.setItem('askedAI', 1);

    $.ajax({
      type: 'POST',
      url: '/actions/ai.php',
      data: {
        text: JSON.stringify($('#text').val()),
        csrf: config.csrf,
      },
      success(response) {
        message("Ganz vielleicht könnte dieser Vorschlag interessant sein: <ul id=\"ai-suggestions\">" + response + "</ul>");
    
        console.log(response)
        $('#ai-suggestions li').click(function() {
            $('#text').val($(this).text());
            $('#text').trigger('propertychange');
            message('');
        });

       },
      error(response) {
        console.log(response);
      },
    });
}

localStorage.setItem('askedAI', 0);
$('#text').blur(function() {
    askAI();
});
