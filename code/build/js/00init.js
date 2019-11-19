var draw = SVG().addTo('#canvas').size(info.width,info.height)

draw.rect(info.width,info.height).move(0, 0).fill('green');

var bgpic = {
    width: 1920/4,
    height: 1280/4,
    filename: 'fuchs.jpg'
}

$( document ).ready(function() {
    afterUpload(bgpic);
});