function askAI() {
    console.log("HI")
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
        console.log("direct",response)
        response = JSON.parse(response);
        if(response.length == 0 ) { 
            return;
        }

        console.log("parsed",response)
        let choices = '';
        for (let i = 0; i < response.length; i++) {
            choices += '<li>' + response[i] + '</li>';
        }

        message("Vielleicht könnte dieser Vorschlag interessant sein: <ul id=\"ai-suggestions\">" + choices + "</ul>");
    
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

$('#ask-ai').click(function() {
    askAI();
});
