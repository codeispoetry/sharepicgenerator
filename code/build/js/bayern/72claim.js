const claim = {
    svg: draw.circle(0),

    draw(){
        claim.svg.remove();
        let color = $('#claimColor').val();
        claim.svg = draw.text($('#claim').val().toUpperCase()).fill( color ).move(15, 16).font(
            {
                family: 'ArvoGruen',
                size: 18,
                anchor: 'left',
                weight: 300
            }
        )
    },
};
claim.draw();

$('#claim').bind('input propertychange', claim.draw);



var claimColors = ["white","black","#46962b","#E6007E","#FEEE00"];
var claimColorIndex = 0;

$('.claim-change-color').click( function(){
    claimColorIndex++;
    claimColorIndex %= claimColors.length;
    $('#claimColor').val(claimColors[ claimColorIndex ]);
    claim.draw();
});

