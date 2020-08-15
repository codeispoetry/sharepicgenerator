$('#pixabayopener').click(() => {
  $('head meta[name="viewport"]').attr('content', 'width=device-width, initial-scale=1');

  $('#pixabay').addClass('active');
});

$('#pixabay-form').submit((e) => {
  e.preventDefault();
  getPixabayImages($('#pixabay .q').val());
  return false;
});

const page = 1;

function getPixabayVideos(q) {
  $('#videos-tab').tab('show');
  $('#pixabay-videos .results').html('<div class="col-12">Suche Videos ...</div>');

  const url = `https://pixabay.com/api/videos/?key=${config.pixabay.apikey}&q=${encodeURIComponent(q)}&page=${page}&per_page=100`;

  $.ajax({
    url,
    success(data, textStatus, jqXHR) {
      $('#pixabay-videos .results').html('');
      data.hits.forEach((video) => {
        $('#pixabay-videos .results').append(`<div class="col-12 col-md-3 video pb-4"><video controls><source src="${video.videos.tiny.url}" type="video/mp4"></video><button class="btn btn-outline-primary btn-sm" data-url="${video.videos.small.url}" data-user="${video.user}">verwenden</button></div>`);
      });

      $('#pixabay-videos .results button').click(function () {
        const pixabayAttribution = $(this).data('user');
        uploadFileByUrl($(this).data('url'), () => {
          setCopyright(pixabayAttribution, 'pixabay');

          config.usePixabay = 'pixabay';
        });
      });
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },
  });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', (e) => {
  e.target; // newly activated tab
  e.relatedTarget; // previous active tab
  const id = $(e.target).attr('id');
  if (id == 'videos-tab') {
    if ($('#pixabay .q').val() == '') {
      return;
    }
    getPixabayVideos($('#pixabay .q').val());
  }
});

function getPixabayImages(q) {
  const url = `https://pixabay.com/api/?key=${config.pixabay.apikey}&q=${encodeURIComponent(q)}&image_type=photo&page=${page}&per_page=100`;

  $('#images-tab').tab('show');
  $('#pixabay-images .results').html('Suche Bilder ... ');

  $('#pixabay-link').attr('href', `https://pixabay.com/images/search/${encodeURIComponent(q)}`);

  $.ajax({
    url,
    success(data, textStatus, jqXHR) {
      $('#pixabay-images .results').html('');
      data.hits.forEach((image) => {
        $('#pixabay-images .results').append(`<img src="${image.previewURL}" data-url="${image.largeImageURL}" data-user="${image.user}" class="img-fluid">`);
      });

      $('#pixabay-images .results>img').click(function () {
        const pixabayAttribution = $(this).data('user');
        uploadFileByUrl($(this).data('url'), () => {
          setCopyright(pixabayAttribution, 'pixabay');

          config.usePixabay = 'pixabay';
        });
      });
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },

  });
}
