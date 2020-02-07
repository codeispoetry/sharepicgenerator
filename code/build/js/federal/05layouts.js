function showLayout(){
   $('[data-layout]').removeClass("btn-info").addClass("btn-outline-info");

    config.layout =  $(this).data("layout");
    $(this).addClass("btn-info").removeClass("btn-outline-info");

    $(".noquote").toggleClass("d-none");

    // this better with trigger
    background.svg.unmask();
    quote.draw();
    inverted.draw();
    text.draw();
}

$('[data-layout]').click( showLayout );