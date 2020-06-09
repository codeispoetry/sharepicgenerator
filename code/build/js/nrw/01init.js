$(document).ready(function () {
    $('#text').val("!Grün ist\ndie Zukunft.");
    $('#textX').val(500);
});

function reset(){
    // do nothing, stay here
    if( pin != undefined ) {
        pin.draw();
        claim.draw();
    }
}
