$(document).ready(() => {
  $('.sizepicker').each(function setColorpicker(index) {
    $(this).append('<i class="fas fa-text-height"></i>');

    const sizes = $(this).data('sizes').split(',');
    let dots = '';

    sizes.forEach((item) => {
      dots += `<span class="dot" style="" data-size="${item}">${item}</span>`;
    });

    $(this).append(`<div class="palette-container" id="palette-container-${index}"><div class="palette">${dots}</div></div>`);

    const width = sizes.length * 25;
    // eslint-disable-next-line prefer-template
    const style = $('<style>.colorpicker:hover #palette-container-' + index + '{ width: ' + width + 'px; }</style>');
    $('html > head').append(style);
  });

  $('.sizepicker .dot').click(function setColor() {
    const size = $(this).data('size');
    const field = $(this).parents('.sizepicker').data('field');
    const action = $(this).parents('.sizepicker').data('action');

    $(field).val(size);

    // eslint-disable-next-line no-eval
    eval(action);
  });
});
