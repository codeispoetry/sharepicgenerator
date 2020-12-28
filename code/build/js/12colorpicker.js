$(document).ready(() => {
  $('.colorpicker').each(function setColorpicker(index) {
    $(this).append('<i class="fas fa-palette"></i>');

    const colors = $(this).data('colors').split(',');
    let dots = '';

    colors.forEach((item) => {
      dots += `<span class="dot" style="background-color:${item}" data-color="${item}"></span>`;
    });

    $(this).append(`<div class="palette-container" id="palette-container-${index}"><div class="palette">${dots}</div></div>`);

    const width = colors.length * 25;
    // eslint-disable-next-line prefer-template
    const style = $('<style>.colorpicker:hover #palette-container-' + index + '{ width: ' + width + 'px; }</style>');
    $('html > head').append(style);
  });

  $('.colorpicker .dot').click(function setColor() {
    const color = $(this).data('color');
    const field = $(this).parents('.colorpicker').data('field');
    const action = $(this).parents('.colorpicker').data('action');

    $(field).val(color);

    // eslint-disable-next-line no-eval
    eval(action);
  });
});
