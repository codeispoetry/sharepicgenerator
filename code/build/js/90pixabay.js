$('.pixabay-direct-search').click(() => {
  $('head meta[name="viewport"]').attr('content', 'width=device-width, initial-scale=1');
  performPixabaySearch();
});

function performPixabaySearch() {
  $('#pixabay-search').show();
  $('#canvas-area').slideUp();

  if (config.pixabaySearchIn === 'video') {
    getPixabayVideos($('#pixabay-direct-search-q').val());
  } else {
    getPixabayImages($('#pixabay-direct-search-q').val());
  }
}

$('#pixabay-direct-search-q').on('keyup', (e) => {
  if (e.key === 'Enter' || e.keyCode === 13) {
    performPixabaySearch();
  }
});
const page = 1;

function getPixabayVideos(q) {
  $('#pixabay-search .results').html('<div class="col-12">Suche Videos ...</div>');

  const url = `https://pixabay.com/api/videos/?key=${config.pixabay.apikey}&q=${encodeURIComponent(q)}&page=${page}&per_page=100`;

  $.ajax({
    url,
    success(data) {
      $('#pixabay-search .results').html('');
      data.hits.forEach((video) => {
        $('#pixabay-search .results').append(`
          <div class="col-12 col-md-3 video pb-4">
            <video id="v${video.id}">
              <source src="${video.videos.tiny.url}" type="video/mp4">
            </video>
            <button class="btn btn-outline-secondary btn-sm play" data-id="v${video.id}">abspielen</button>
            <button class="btn btn-outline-primary btn-sm use" data-url="${video.videos.small.url}" data-user="${video.user}">verwenden</button>
            <small>${video.duration} Sek.</small>
          </div>`);
      });

      $('#pixabay-search .results button.use').click(function clickButton() {
        const pixabayAttribution = $(this).data('user');
        $('#pixabay-search').hide();
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

      $('#pixabay-search .results button.play').click(function clickButton() {
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

$('a[data-toggle="tab"]').on('shown.bs.tab', (e) => {
  // e.target; -> newly activated tab
  // e.relatedTarget; -> previous active tab
  const id = $(e.target).attr('id');
  if (id === 'videos-tab') {
    if ($('#pixabay .q').val() === '') {
      return;
    }
    getPixabayVideos($('#pixabay .q').val());
  }
});

function getPixabayImages(q) {
  const url = `https://pixabay.com/api/?key=${config.pixabay.apikey}&q=${encodeURIComponent(q)}&image_type=photo&page=${page}&per_page=100`;

  $('#pixabay-search .results').html('Suche Bilder ... ');

  $('#pixabay-link').attr('href', `https://pixabay.com/images/search/${encodeURIComponent(q)}`);

  $.ajax({
    url,
    success(data) {
      $('#pixabay-search .results').html('');
      data.hits.forEach((image) => {
        $('#pixabay-search .results').append(`<img src="${image.previewURL}" data-url="${image.largeImageURL}" data-user="${image.user}" class="img-fluid">`);
      });

      $('#pixabay-search .results>img').click(function clickImg() {
        const pixabayAttribution = $(this).data('user');
        $('#pixabay-search').hide();
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
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },

  });
}

$('.pixabay-search-in').click(function pixabaySearchIn() {
  $('.pixabay-selected-type').removeClass(`fa-${config.pixabaySearchIn}`);
  config.pixabaySearchIn = $(this).data('files');
  $('.pixabay-selected-type').addClass(`fa-${config.pixabaySearchIn}`);
});
