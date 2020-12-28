function getUnsplashImages(q) {
  $('#imagedb-search').show();
  $('#canvas-area').slideUp();

  $('#imagedb-search .results').html('Suche Bilder bei Unsplash ... ');
  $('#imagedb-link').attr('href', `https://unsplash.com/s/photos/${encodeURIComponent(q)}`);
  $('#imagedb-carrier').html('Unsplash');

  $.ajax({
    type: 'POST',
    url: '/actions/unsplash.php',
    data: {
      q,
    },
    success(data) {
      const info = JSON.parse(data);
      $('#imagedb-search .results').html('');
      info.results.forEach((photo) => {
        $('#imagedb-search .results').append(`<img src="${photo.urls.thumb}" data-url="${photo.urls.regular}" data-user="${photo.user.name}" class="img-fluid">`);
      });
      addClickActions('unsplash');
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },
  });
}
