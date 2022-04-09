/* eslint-disable no-unused-vars */
/* eslint-disable no-undef */
$('.imagedb-search-in').click(function imageDBSearchIn() {
  $('.imagedb-selected-type').removeClass(`fa-images`);
  $('.imagedb-selected-type').removeClass(`fa-video`);
  config.imageDBSearchIn = $(this).data('files');
  const icon = $(this).data('icon');
  $('.imagedb-selected-type').addClass(`fa-${icon}`);

  if ($('#imagedb-direct-search-q').val().length) {
    performImageDBSearch();
  }
});

$('.imagedb-direct-search').click(() => performImageDBSearch());

function performImageDBSearch(carrier = false) {
  $('head meta[name="viewport"]').attr('content', 'width=device-width, initial-scale=1');
  if (carrier) {
    config.imageDBSearchIn = carrier;
  }

  switch (config.imageDBSearchIn) {
    case 'pixabay-video':
      getPixabayVideos($('#imagedb-direct-search-q').val());
      break;
    default:
      getPixabayImages($('#imagedb-direct-search-q').val());
  }

  $.ajax({
    type: 'POST',
    url: '/actions/logging.php',
    data: {
      q: $('#imagedb-direct-search-q').val(),
      carrier: config.imageDBSearchIn,
    },
    error(response) {
      console.log(response);
    },
  });
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
      setCopyright(attribution, carrier.replace(/-.*/, ''));

      if (typeof reDraw === 'function') {
        // eslint-disable-next-line no-undef
        reDraw(false);
      }

      $('.picture').collapse('hide');
      config.backgroundSource = carrier;
      $('#canvas-area').slideDown();
      $('#imagedb-search').hide();
      $('#waiting').hide();
    });
  });

  $('[data-carrier]', '.imagedb-hint').addClass('text-primary');
  $(`[data-carrier=${carrier}]`, '.imagedb-hint').removeClass('text-primary');
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
