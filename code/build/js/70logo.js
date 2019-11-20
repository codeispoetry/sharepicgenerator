var logo;


logo = draw.image('assets/sonnenblume.svg', function (event) {
    logo.size(draw.width() / 13).x(draw.width() - 110).y(10);
});


function setLogoPosition() {
    logo.x(draw.width() - logo.width() - 10).y(10);
}


$('#logoresize').bind('input propertychange', function () {
    let val = parseInt($(this).val());
    logo.size(val);

    scale = val / 100;
    claim.transform({scale: scale, origin: 'top left'});
    subline.transform({scale: scale, origin: 'bottom left'});
    setLogoPosition();
});
