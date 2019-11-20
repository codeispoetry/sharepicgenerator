
const subline = {

    svg: draw.circle(0),

    draw(){
        this.svg.remove();
        this.svg = draw.text($('#subline').val().toUpperCase()).fill('white').move(15, draw.height() - 24).font(
            {
                family: 'Arvo',
                size: 15,
                anchor: 'left',
                weight: 700
            }
        )
    },
};

$('#subline').bind('input propertychange', subline.draw);



