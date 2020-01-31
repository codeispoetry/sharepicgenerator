var textColors = ["white","black","#46962b","#E6007E","#FEEE00"];


function textChangeColor(){
    let textColorIndex = parseInt( $('#textColor').val() );
    textColorIndex++;
    textColorIndex %= textColors.length;
    
    $('#textColor').val( textColorIndex );

    text.draw();
    quote.draw();
}