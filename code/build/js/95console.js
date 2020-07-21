function runCode(){
    let code = $('#code').val();

    eval( code );
}

$('.runcode').click(runCode);