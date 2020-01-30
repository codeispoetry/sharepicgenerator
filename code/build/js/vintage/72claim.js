const claim = {
    svg: draw.circle(0),

    draw(){
        claim.svg.remove();
        let color = $('#claimColor').val();
   
        claim.svg = draw.text("ökologisch · sozial · basisdemokratisch · gewaltfrei").fill( color ).move(19,  draw.height() - 30).font(
            {
                family: 'RockoUltraFLF',
                size: 22,
                anchor: 'left',
                weight: 'normal'
            }
        )
    },
};
claim.draw();



var claimColors = ["white","black","#46962b","#E6007E","#FEEE00"];
var claimColorIndex = 0;

$('.claim-change-color').click( function(){
    claimColorIndex++;
    claimColorIndex %= claimColors.length;
    $('#claimColor').val(claimColors[ claimColorIndex ]);
    claim.draw();
    subline.draw();
});
