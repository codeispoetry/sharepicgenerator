/* eslint-disable no-undef */
$('[data-maxlines]').bind('input propertychange', reduceLines);

function reduceLines() {
  const text = $(this).val().split(/\n/, $(this).data('maxlines'));
  $(this).val(text.join('\n'));
}