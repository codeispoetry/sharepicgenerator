const ad = {

  svg: draw.text('sharepicgenerator.de')
    .move(10, 10)
    .font({ family: 'PT Sans', size: 10 })
    .click(() => {
      if (confirm('Willst Du den Hinweis löschen? Du kannst ihn unter dem Reiter "Zusatz" wieder einblenden.')){
        $('#show-advertising').attr('checked', false);
        ad.svg.hide();
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
  },

  show() {
    ad.svg.show();
  },

  toggle() {
    if (ad.svg.visible()) {
      ad.svg.hide();
    } else {
      ad.svg.show();
    }
  },
};

ad.setPosition();

$('#show-advertising').bind('change', () => {
  ad.toggle();
});
