function showLayout(){
    $('[data-layout]').toggleClass("btn-info");
    $('[data-layout]').toggleClass("btn-outline-info");

    $(".noquote").toggleClass("d-none");

    config.layout =  $('[data-layout].btn-info').data("layout");

    // this better with trigger
    quote.draw();
    text.draw();
}