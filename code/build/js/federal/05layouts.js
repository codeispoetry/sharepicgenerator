function showLayout(){
   config.layout =  $('#layout').val();


    $(".noquote").toggleClass("d-none");

    // this better with trigger
    background.svg.unmask();
    quote.draw();
    inverted.draw();
    text.draw();
}

$('#layout').click( showLayout );