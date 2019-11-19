var draw = SVG().addTo('#canvas').size(info.width,info.height)

var bgpic = {
    width: 1920 / 3,
    height: 1080 / 3,
    filename: 'assets/bg.jpg'
}

$( document ).ready(function() {
    afterUpload(bgpic);
});

