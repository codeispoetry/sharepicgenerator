const page = 1;

function getPixabayVideos(q) {
  $('#imagedb-search').show();
  $('#canvas-area').slideUp();

  $('#imagedb-search .results').html('<div class="col-12">Suche Videos ...</div>');

  const url = `https://pixabay.com/api/videos/?key=${config.pixabay.apikey}&q=${encodeURIComponent(q)}&page=${page}&per_page=100`;

  $.ajax({
    url,
    success(data) {
      $('#imagedb-search .results').html('');
      data.hits.forEach((video) => {
        $('#imagedb-search .results').append(`
          <div class="col-12 col-md-3 video pb-4">
            <video id="v${video.id}">
              <source src="${video.videos.tiny.url}" type="video/mp4">
            </video>
            <button class="btn btn-outline-secondary btn-sm play" data-id="v${video.id}">abspielen</button>
            <button class="btn btn-outline-primary btn-sm use" data-url="${video.videos.small.url}" data-user="${video.user}">verwenden</button>
            <small>${video.duration} Sek.</small>
          </div>`);
      });

      $('#imagedb-search .results button.use').click(function clickButton() {
        const pixabayAttribution = $(this).data('user');
        $('#imagedb-search').hide();
        uploadFileByUrl($(this).data('url'), () => {
          setCopyright(pixabayAttribution, 'pixabay');

          if (typeof reDraw === 'function') {
            // eslint-disable-next-line no-undef
            reDraw(false);
          }

          $('.picture').collapse('hide');
          config.backgroundSource = 'pixabay';
          $('#canvas-area').slideDown();
          $('#pixabay-search').hide();
          $('#waiting').hide();
        });
      });

      $('#imagedb-search .results button.play').click(function clickButton() {
        const videoId = $(this).data('id');
        const videoElement = $(`#${videoId}`).get(0);

        if (videoElement.paused) {
          videoElement.play();
          $(this).html('stop');
        } else {
          videoElement.pause();
          $(this).html('abspielen');
        }
      });
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },
  });
}

function getPixabayImages(q) {
  $('#imagedb-search').show();
  $('#canvas-area').slideUp();

  const url = `https://pixabay.com/api/?key=${config.pixabay.apikey}&q=${encodeURIComponent(q)}&image_type=photo&page=${page}&per_page=100`;

  $('#imagedb-search .results').html('Suche Bilder bei Pixabay ... ');

  $('#imagedb-link').attr('href', `https://pixabay.com/images/search/${encodeURIComponent(q)}`);
  $('#imagedb-carrier').html('Pixabay');

  $.ajax({
    url,
    success(data) {
      $('#imagedb-search .results').html('');
      data.hits.forEach((image) => {
        $('#imagedb-search .results').append(`<img src="${image.previewURL}" data-url="${image.largeImageURL}" data-user="${image.user}" class="img-fluid">`);
      });
      addClickActions('pixabay');

      if (!data.hits.length) {
        noPicturesFound();
      }
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },

  });
}
