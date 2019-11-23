
const subline = {

    svg: draw.circle(0),

    draw(){
        subline.svg.remove();
        subline.svg = draw.text($('#subline').val().toUpperCase()).fill('white').move(15, draw.height() - 24).font( secondaryfont)
    },
};

$('#subline').bind('input propertychange', subline.draw);



