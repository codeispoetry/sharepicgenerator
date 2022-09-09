/* eslint-disable no-undef */
const alltexts = {
    font: {
        family: 'ArvoGruen',
        leading: '1.05em',
        size: 20,
        },
    svg1: draw.circle(),
    svg2: draw.circle(),
    svg3: draw.circle(),
    svg4: draw.circle(),
    svg5: draw.circle(),

     
    draw() {
        alltexts.svg1.remove();
        alltexts.svg1 = draw.text($('#text1').val().toUpperCase())
            .font(Object.assign(alltexts.font, { size: 25 }))
            .fill('white')
            .attr('xml:space', 'preserve')
            .attr('style', 'white-space:pre');

        alltexts.svg2.remove();
        alltexts.svg2 = draw.text($('#text2').val())
            .font(Object.assign(alltexts.font, { size: 20 }))
            .fill('white')
            .attr('xml:space', 'preserve')
            .attr('style', 'white-space:pre');
    
        const left1 = 30;
        const left2 = 220;

        alltexts.svg3.remove();
        alltexts.svg3 = draw.text($('#text3').val())
            .font(Object.assign(alltexts.font, { size: 20 }))
            .fill('white')
            .attr('xml:space', 'preserve')
            .attr('style', 'white-space:pre');
        
        alltexts.svg4.remove();
        alltexts.svg4 = draw.text($('#text4').val())
            .font(Object.assign(alltexts.font, { size: 20 }))
            .fill('white')
            .attr('xml:space', 'preserve')
            .attr('style', 'white-space:pre');
        
        alltexts.svg5.remove();
        alltexts.svg5 = draw.text($('#text5').val())
            .font(Object.assign(alltexts.font, { size: 14 }))
            .fill('white')
            .attr('xml:space', 'preserve')
            .attr('style', 'white-space:pre');
        

        alltexts.svg1.move(logo.svg.x() * 0.9, logo.svg.y() - alltexts.svg1.bbox().h);
        alltexts.svg2.move(logo.svg.x() + logo.svg.width() * 0.4, logo.svg.y() + logo.svg.height() * 0.9);

        
        const rightColumnHeight = (alltexts.svg5.bbox().h == 0) ? alltexts.svg4.bbox().h : alltexts.svg4.bbox().h + alltexts.svg5.bbox().h + 10
        const highest = Math.max( alltexts.svg3.bbox().h, rightColumnHeight);
        const bottomY = draw.height() - highest - 30;


        alltexts.svg3.move(left1, bottomY);
        alltexts.svg4.move(left2, bottomY);
        alltexts.svg5.move(left2, draw.height() - alltexts.svg5.bbox().h - 30);


    }
}

$('#text1, #text2, #text3, #text4, #text5').bind('input propertychange', alltexts.draw);

