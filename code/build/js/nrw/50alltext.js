const textColors = ['white', 'black', '#46962b', '#E6007E', '#FEEE00'];

function textChangeColor() {
  const id = $(this).data('id');

  let textColorIndex = parseInt($(`#textColor${id}`).val(), 10);
  textColorIndex += 1;
  textColorIndex %= textColors.length;

  $(`#textColor${id}`).val(textColorIndex);

  text.draw();
}

$('.text-change-color').click(textChangeColor);
