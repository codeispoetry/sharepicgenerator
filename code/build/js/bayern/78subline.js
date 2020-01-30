
const subline = {

    svg: draw.circle(0),

    draw(){
        subline.svg.remove();
        let color = $('#sublineColor').val();
        subline.svg = draw.text($('#subline').val().toUpperCase()).fill( color ).move(15, draw.height() - 36).font(
            {
                family: 'ArvoGruen',
                size: 18,
                anchor: 'left',
                weight: 300
            }
        )
    },
};

$('#subline').bind('input propertychange', subline.draw);


var sublineColors = ["white","black","#46962b","#E6007E","#FEEE00"];
var sublineColorIndex = 0;

$('.subline-change-color').click( function(){
    sublineColorIndex++;
    sublineColorIndex %= sublineColors.length;
    $('#sublineColor').val(sublineColors[ sublineColorIndex ]);
    subline.draw();
});

