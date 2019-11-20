const draw = SVG().addTo('#canvas');
var info = { foo: null};

const bgpic = {
    width: 800,
    height: 450,
    originalWidth: 1920,
    originalHeight: 1080,
    filename: 'assets/bg_small.jpg'
};

$(document).ready(function () {
    afterUpload(bgpic);
});



