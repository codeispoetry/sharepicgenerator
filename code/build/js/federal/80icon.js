const icon = {
  isLoaded: false,

  load() {
    if (this.svg) this.svg.remove();
    icon.isLoaded = false;

    const file = $('#iconfile').val();
    this.svg = draw.image(file, () => {
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

$('#iconsize').on('change', function changeIcon() {
  if ($(this).val() === 0) {
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
    success(data) {
      $('#iconoverlay .results').html('');
      const json = JSON.parse(data);

      json.hits.forEach((thisIcon) => {
        $('#iconoverlay .results').append(`<div class="chooseicon" data-icon-url="${thisIcon.icon_url}"  data-attribution="${thisIcon.attribution}"><img src="${thisIcon.preview_url}" title="${thisIcon.attribution}"/></div>`);
      });

      if (json.hits.length === 0) {
        $('#iconoverlay .results').append('<div class="col-12 bg-danger text-white p-3 text-center">Keine Icons gefunden. Bitte suche auf Englisch.</div>');
      }

      $('#iconoverlay .results .chooseicon').click(function clickChoose() {
        $('#waiting').addClass('active');
        $('#iconoverlay').removeClass('active');

        const nounprojectattribution = $(this).data('attribution');

        $.get('/nounproject/get_icon.php', { icon_url: $(this).data('icon-url') })
          .done((iconData) => {
            if (iconData === 'error') {
              console.log('error downloading icon');
            } else {
              $('#iconfile').val(`/tmp/${iconData}`);
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
