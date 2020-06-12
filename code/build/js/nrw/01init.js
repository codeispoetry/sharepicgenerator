const bgpic = {
    width: 800,
    height: 450,
    originalWidth: 1920,
    originalHeight: 1080,
    filename: '../assets/nrw/wiese_small.jpg'
};

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
