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
      $('#imagedb-search .results').html('');
      const info = JSON.parse(data);
      if (info.success === 'false') {
        $('#imagedb-search .results').html('Es ist ein API-Fehler aufgetreten.');
        return false;
      }

      info.results.forEach((photo) => {
        $('#imagedb-search .results').append(`<img src="${photo.urls.thumb}" data-url="${photo.urls.regular}" data-user="${photo.user.name}" class="img-fluid">`);
      });

      if (!info.results.length) {
        noPicturesFound();
      }

      addClickActions('unsplash-images');
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },
  });
}
