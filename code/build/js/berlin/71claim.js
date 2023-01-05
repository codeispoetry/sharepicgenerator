const claimBerlin = {
    
    svg: draw.group(),
    
    draw() {
        claimBerlin.svg.remove();
        claimBerlin.svg = draw.group().addClass('draggable').draggable();

        claimBerlin.svg.on('dragend.namespace', function berlinclaimDragEnd() {
            $('#claimX').val(Math.round(this.x()));
            $('#claimY').val(Math.round(this.y()));
          });

        const claimText = $('input[name="claim"]:checked').val();

        const claimBerlinText = draw.text(claimText).font({
            family: 'BereitBold',
            anchor: 'left',
            size: 20,
        }).fill('#006a52').move(6, 3);

        const fondW = claimBerlinText.bbox().width + 12;
        const claimBerlinFond = draw.rect(fondW,30).fill('#95c11f').move(0,0).back();

        claimBerlin.svg.add(claimBerlinFond);
        claimBerlin.svg.add(claimBerlinText);
        claimBerlin.svg.front();

        claimBerlin.setPosition();
    },

    setPosition() {

        claimBerlin.svg.size(draw.width() * 0.33, null);
        let x = ( draw.width() - claimBerlin.svg.width() ) / 2;
        let y = draw.height() - claimBerlin.svg.height();

        if( $('#frame').is(':checked') === true ) {
            y -= 10;
        }

        x = $('#claimX').val() || x;
        y = $('#claimY').val() || y;

        claimBerlin.svg.move(x, y) ;
    },
  };

$('input[name="claim"]').bind('click', claimBerlin.draw);

$('#setClaim').bind('click', function() {
    $('#claimX').val('');
    $('#claimY').val('');
    claimBerlin.setPosition();
});
