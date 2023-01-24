const textColors = ['white', 'black', '#46962b', '#E6007E', '#FEEE00'];

function textChangeColor() {
  let textColorIndex = parseInt($('#textColor').val(), 10);
  textColorIndex += 1;
  textColorIndex %= textColors.length;

  $('#textColor').val(textColorIndex);

  text.draw();
  quote.draw();
}

function alignCenter() {
  const x = (draw.width() - text.svg.width()) / 2;
  const y = (draw.height() - text.svg.height()) / 2;

  text.svg.move(x, y);

  $('#textX').val(Math.round(x));
  $('#textY').val(Math.round(y));
  text.bounce();
  text.positionGrayBackground();
}
$('.aligncenter').click(alignCenter);

$('.delete-font').click(function deleteLogo() {
  // eslint-disable-next-line no-restricted-globals
  if (!confirm('Schrift wirklich löschen?')) {
    return false;
  }
  const file = $(this).data('file');

  $.post('/actions/delete.php', { action: 'font', csrf: config.csrf, file })
    .done((response) => {
      const data = JSON.parse(response);

      if (data.error) {
        alert(data.error.code);
        return false;
      }

      alert('Die Schrift wurde gelöscht.');
      $(this).parent().hide();
      return true;
    });

  return true;
});
