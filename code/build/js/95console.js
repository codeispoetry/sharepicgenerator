function runCode() {
  const code = $('#code').val();

  // eslint-disable-next-line no-eval
  eval(code);
}

$('.runcode').click(runCode);
