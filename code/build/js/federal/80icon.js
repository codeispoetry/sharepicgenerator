const icon = {
  isLoaded: false,

  load() {
    if (this.svg) this.svg.remove();
    icon.isLoaded = false;

    const file = $('#iconfile').val();
    this.svg = draw.image(file, (event) => {
      icon.isLoaded = true;
      icon.svg.size(1).move(-100, -100); // cannot be resized to zero
      text.draw();
      $('.iconsizeselectwrapper').removeClass('d-none');
    });

    this.svg.on('error', (e) => {
      console.log(file, e);
    });
  },

  remove() {
    if (this.svg) this.svg.remove();
    this.isLoaded = false;
  },
};

$('#iconsize').on('change', function () {
  if ($(this).val() == 0) {
    icon.remove();
  }
  text.draw();
});

$('#iconopener').click(() => {
  $('head meta[name="viewport"]').attr('content', 'width=device-width, initial-scale=1');
  $('#iconoverlay').addClass('active');
});

$('#iconoverlay form').submit(() => {
  getIcons($('#iconoverlay .q').val());
  return false;
});

function getIcons(q) {
  const url = `/nounproject/load_results.php?q=${q}`;
  $('#iconoverlay .results').html('suche Icons ');
  const loading = window.setInterval(() => {
    $('#iconoverlay .results').append(' . ');
  }, 10);
  $.ajax({
    url,
    success(data, textStatus, jqXHR) {
      $('#iconoverlay .results').html('');
      const json = JSON.parse(data);

      json.hits.forEach((icon) => {
        $('#iconoverlay .results').append(`<div class="chooseicon" data-icon-url="${icon.icon_url}"  data-attribution="${icon.attribution}"><img src="${icon.preview_url}" title="${icon.attribution}"/></div>`);
      });

      if (json.hits.length == 0) {
        $('#iconoverlay .results').append('<div class="col-12 bg-danger text-white p-3 text-center">Keine Icons gefunden. Bitte suche auf Englisch.</div>');
      }

      $('#iconoverlay .results .chooseicon').click(function () {
        $('#waiting').addClass('active');
        $('#iconoverlay').removeClass('active');

        const nounprojectattribution = $(this).data('attribution');

        $.get('/nounproject/get_icon.php', { icon_url: $(this).data('icon-url') })
          .done((data) => {
            if (data == 'error') {
              console.log('error downloading icon');
            } else {
              $('#iconfile').val(`/tmp/${data}`);
              icon.load();
              setCopyright(nounprojectattribution, 'nounproject');
            }
            closeOverlay();
          });
      });

      window.clearInterval(loading);
    },
    error(data, textStatus, jqXHR) {
      console.log(data, jqXHR);
    },
  });
}
