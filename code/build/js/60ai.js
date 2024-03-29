function askAI() {
    $('.intro-text', '.ai-suggest').html('Augenblick bitte ... eine künstliche Intelligenz sucht nach Vorschlägen.');
    log.ai = 'tested';
    $.ajax({
      type: 'POST',
      url: '/actions/ai.php',
      data: {
        text: JSON.stringify($('#text').val()),
        csrf: config.csrf,
      },
      success(response) {
        if( response.length == 0 ) {
            return;
        }
        response = JSON.parse(response);
        if(response.length == 0 ) { 
            return;
        }

        if(response.error) {
          alert("Fehler: " + response.message);
          $('.ai-suggest').removeClass('active');
          return;
        }

        if(response[0] == '') { 
          $('.intro-text', '.ai-suggest').html("Tut mir leid, es wurden keine Vorschläge gefunden.");
          return;
        }
        let choices = '';
        for (let i = 0; i < response.length; i++) {
            choices += '<li>' + response[i] + '</li>';
        }

        $('.intro-text', '.ai-suggest').html("<small>Klicke auf einen Vorschlag, um ihn zu übernehmen.</small>");
        $('ul#ai-suggestions').html(choices);

        $('#ai-suggestions li').click(function(event) {
            const text = $(this).text().replace(/[–| ( - )]/gm, "\n");
            $('#text').val(text);
            $('#text').trigger('propertychange');
            $('.ai-suggest').removeClass('active');
            $('ul#ai-suggestions').html('');
            log.ai = 'used';
            event.stopPropagation()
        });

       },
      error(response) {
        console.log(response);
      },
    });
}

$('.ai-suggest-trigger').click(function() {
  if($('.ai-suggest').hasClass('active')) {
    return;
  }
  $('.ai-suggest').addClass('active');
  askAI();
});

$('.ask-ai-close').click(function(event) {
  $('.ai-suggest').removeClass('active');
  event.stopPropagation()
});
