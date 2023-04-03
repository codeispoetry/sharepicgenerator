$('.ai-image-trigger').click(function() {
  if($('#ai-image-prompt').val().length === 0) {
    return;
  }

  if($(this).prop('disabled')) {
    return;
  }
  $(this).prop('disabled', true);
  $(this).html('Augenblick...');
  getAIImages();
});

function getAIImages() {
  if($('#ai-image-prompt').val().length === 0) {
    return;
  }

  const today = 1 * new Date().toISOString().substring(0, 10).replace(/-/g, '');
  const lastUsage = config.user.prefs.dalleUsage || 0;
  const gracePeriodInDays = today - lastUsage;
  if(gracePeriodInDays < 1) { 
    alert("Leider kannst Du die KI nur ein Mal pro Tag nutzen. Für mehr Bilder, gehe bitte zu https://labs.openai.com ");
    $('.dalle').hide();
    return;
  }

  config.user.prefs.dalleUsage = today;
  setUserPrefs();

  $('#imagedb-search').show();
  $('#canvas-area').slideUp();

  $('#imagedb-search .results').html('Erzeuge Bilder ... Augenblick bitte.');

  $('#imagedb-link').attr('href', `https://openai.com/dall-e-2/`);
  $('#imagedb-carrier').html('DALL·E 2');



  log.dalle = $('#ai-image-prompt').val();
  $.ajax({
    type: 'POST',
    url: '/actions/dalle.php',
    data: {
      prompt: JSON.stringify($('#ai-image-prompt').val()),
      csrf: config.csrf,
    },
    success(response) {
      $('.ai-image-trigger').html('erzeugen');
      $('.ai-image-trigger').prop('disabled', false);

      $('#imagedb-search .results').html('');
      $('#imagedb-search .results').addClass('dalle-images');

      const data = JSON.parse(response);

      if(data.error) {
        alert("Fehler: " + data.message);
        $('#canvas-area').slideDown();
        $('#imagedb-search').hide();
        return;
      }
     
      for (const image of data.images) {
        $('#imagedb-search .results').append(`<img src="${image}" data-url="${image}" data-user="DALL·E 2" class="img-fluid">`);
      }
      
      addClickActions('pixabay-images');

    },
    error(data, textStatus, jqXHR) {
      console.log("Error", data, textStatus, jqXHR);
    },

  });
}

