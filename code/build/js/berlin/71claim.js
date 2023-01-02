const claimBerlin = {
    
    svg: draw.group(),
    
    draw() {
        const claimBerlinText = draw.text('ZEIT FÜR GRÜN.').font({
            family: 'BereitBold',
            anchor: 'left',
            size: 20,
        }).fill('#006a52'). move(6, 3);

        const claimBerlinFond = draw.rect(118,34).fill('#95c11f').move(0,0).back();

        claimBerlin.svg.add(claimBerlinFond);
        claimBerlin.svg.add(claimBerlinText);
        claimBerlin.svg.front();
    },

    setPosition() {
        claimBerlin.svg.size(draw.width() * 0.33, null);
        const x = ( draw.width() - claimBerlin.svg.width() ) / 2;
        const y = draw.height() - claimBerlin.svg.height() 
        claimBerlin.svg.move(x, y) ;
    },
  };

claimBerlin.draw();
