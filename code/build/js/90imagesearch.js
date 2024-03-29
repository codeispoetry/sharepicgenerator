/* eslint-disable no-unused-vars */
/* eslint-disable no-undef */
$('.imagedb-search-in').click(function imageDBSearchIn() {
  if ($('#imagedb-direct-search-q').val().length) {
    performImageDBSearch();
  }
});

$('.imagedb-direct-search').click(() => performImageDBSearch());

function performImageDBSearch(carrier = false) {
  if ($('#imagedb-direct-search-q').val().length === 0) {
    alert('Bitte gib einen Suchbegriff ein.');
    return;
  }

  $('head meta[name="viewport"]').attr('content', 'width=device-width, initial-scale=1');
  getPixabayImages($('#imagedb-direct-search-q').val());
}

$('#imagedb-direct-search-q').on('keyup', (e) => {
  if (e.key === 'Enter' || e.keyCode === 13) {
    performImageDBSearch();
  }
});

function addClickActions(carrier) {
  $('#imagedb-search .results>img').click(function clickImg() {
    const attribution = $(this).data('user');
    $('#imagedb-search').hide();
    uploadFileByUrl($(this).data('url'), () => {
      setCopyright(attribution);

      $('.picture').collapse('hide');
      config.backgroundSource = carrier;
      $('#canvas-area').slideDown();
      $('#imagedb-search').hide();
      $('#waiting').hide();
      $('#backgroundsize').val(draw.width());
      $('#saturate').val(1);
      $('#backgroundX').val(0);
      // the -1 is for bugfixing, otherwise inkscape produces a blank row sometimes
      $('#backgroundY').val(-1);

    });
  });
}

function noPicturesFound() {
  const q = $('#imagedb-direct-search-q').val();
  $('#imagedb-search .results').html(`Es wurden keine Bilder für ${q} gefunden.`);
}

$(document).ready(() => {
  $('.imagedb-search').click(function imageDBSearch() {
    performImageDBSearch($(this).data('carrier'));
  });
});

const page = 1;

function getPixabayImages(q) {
  $('#imagedb-search').show();
  $('#canvas-area').slideUp();

  const url = `https://pixabay.com/api/?key=${config.pixabay.apikey}&q=${encodeURIComponent(q)}&image_type=photo&page=${page}&per_page=100&lang=de`;
  $('#imagedb-search .results').html('Suche Bilder bei Pixabay ... ');

  $('#imagedb-link').attr('href', `https://pixabay.com/images/search/${encodeURIComponent(q)}`);
  $('#imagedb-carrier').html('Pixabay');

  $.ajax({
    url,
    success(data) {
      $('#imagedb-search .results').html('');
      $('#imagedb-search .results').removeClass('dalle-images');
      
      data.hits.forEach((image) => {
        $('#imagedb-search .results').append(`<img src="${image.previewURL}" data-url="${image.largeImageURL}" data-user="${image.user} / Pixabay" class="img-fluid">`);
      });
      addClickActions('pixabay-images');

      if (!data.hits.length) {
        noPicturesFound();
      }
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },

  });
}