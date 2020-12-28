function getPexelsImages(q) {
  $('#imagedb-search').show();
  $('#canvas-area').slideUp();

  $('#imagedb-search .results').html('Suche Bilder bei Pexels ... ');
  $('#imagedb-link').attr('href', `https://www.pexels.com/de-de/suche/${encodeURIComponent(q)}`);
  $('#imagedb-carrier').html('Pexels');

  $.ajax({
    type: 'POST',
    url: '/actions/pexels.php',
    data: {
      q,
    },
    success(data) {
      const info = JSON.parse(data);
      $('#imagedb-search .results').html('');

      if (info.success === 'false') {
        $('#imagedb-search .results').html('Es ist ein API-Fehler aufgetreten.');
        return false;
      }

      info.photos.forEach((photo) => {
        $('#imagedb-search .results').append(`<img src="${photo.src.tiny}" data-url="${photo.src.large}" data-user="${photo.photographer}" class="img-fluid">`);
      });

      if (!info.photos.length) {
        noPicturesFound();
      }

      addClickActions('pexels');
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },
  });
}
