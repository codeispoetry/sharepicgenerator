function runCode() {
  const code = $('#code').val();

  eval(code);
}

$('.runcode').click(runCode);
