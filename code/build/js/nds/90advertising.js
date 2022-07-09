const ad = {

  svg: draw.text('sharepicgenerator.de')
    .move(10, 10)
    .font({ family: 'PT Sans', size: 10 })
    .click(() => {
      if (confirm('Willst Du den Hinweis löschen? Du kannst ihn unter dem Reiter "Zusatz" wieder einblenden.')){
        $('#show-advertising').prop('checked', false);
        ad.hide();
      }
    }),

  setColor() {
    ad.svg.fill($('#advertisingColor').val());
  },

  setPosition() {
    ad.svg.move(draw.width() - ad.svg.bbox().width - 20, draw.height() - ad.svg.bbox().height - 10);
  },

  hide() {
    ad.svg.hide();
    config.user.prefs.showAd = 0;
    setUserPrefs();
  },

  show() {
    ad.svg.show();
    ad.setPosition();
    config.user.prefs.showAd = 1;
    setUserPrefs();
  },

  toggle() {
    if (ad.svg.visible()) {
      ad.hide();
    } else {
      ad.show();
    }
  },
};

ad.setPosition();

$('#show-advertising').bind('change', () => {
  ad.toggle();
});
