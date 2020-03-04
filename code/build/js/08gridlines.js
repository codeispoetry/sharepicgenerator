$('#gridlines').bind('change', function(){
    $('.gridline').toggleClass('d-none');
});

function showMosaicLines(){
    for (i = 1; i <= 2; i++) {
        $("#canvas").append('<div class="gridline horizontal mosaicline" style="top:' + ( 100 * i / 3 ) + '%;"></div>');
        $("#canvas").append('<div class="gridline vertical mosaicline" style="top:0;left:' + ( 100 * i / 3 ) + '%;"></div>');
    }
}

function deleteMosaicLines(){
    $('.mosaicline').remove();
}

