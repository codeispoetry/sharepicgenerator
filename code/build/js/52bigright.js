const bigright = {
    svg: draw.text(''),
    fond: draw.rect(),
    colors: ['#ffffff', '#ffee00'],
    fontsizes: [20, 20],
    lineheights: [20, 20],
    yBiases: [0, 0],
    linemargin: 0,
    paddingLr: 5,
    font: {
        family: 'Arvo',
        anchor: 'left',
        leading: '1.0em'
    },
    fontoutsidelines: {
        family: 'Arvo',
        size: 6,
        anchor: 'left',
        leading: '1.0em',
        weight: 300
    },

    draw: function () {
        if($('#design').val() != 'bigright') return;

        bigright.svg.remove();
        bigright.svg = draw.group();

        // fond
        bigright.fond.remove();
        bigright.fond = draw.rect( draw.width()/2, draw.height()).dx(draw.width()/2).fill("#46962b");


        let y = 0;
        let lines = $('#text').val().split(/\n/);
        let fontweight = (lines.length <= 3 ) ? 700 : 300;
     

        lines.forEach(function (value, index, array) {
                let style = /^!/.test(value) ? 1 : 0;
                 
                value = value.replace(/^!/, '').toUpperCase();
                // no lodash-syntax, because of Edge
                //let t = draw.text(value).font({...bigright.font, ...{weight: fontweight, size: bigright.fontsizes[style]}}).fill(bigright.colors[style]).move(0, y + bigright.yBiases[style]);
                let t = draw.text(value).font(Object.assign( bigright.font,{weight: fontweight, size: bigright.fontsizes[style]})).fill(bigright.colors[style]).move(0, y + bigright.yBiases[style]);

                bigright.svg.add(t);
                y += bigright.lineheights[style] + bigright.linemargin;
            }
        );

        // add upper and lower line
        let linebefore = draw.rect( bigright.svg.width(), 2).fill( '#ffffff').dy( -4 );
        let lineafter  = linebefore.clone().dy( bigright.svg.height() + 6 );
        bigright.svg.add( linebefore);
        bigright.svg.add( lineafter );

        // text above and below the line
        let textbefore = draw.text( $('#textbefore').val() ).font( bigright.fontoutsidelines ).fill('#ffffff').dy(-14);
        let textafter = draw.text( $('#textafter').val() ).font( bigright.fontoutsidelines ).fill('#ffffff').dy( bigright.svg.height() - 2 );
        bigright.svg.add( textbefore );
        bigright.svg.add( textafter );


        bigright.svg.size(draw.width() * .4).move( draw.width() * .55, (draw.height() - bigright.svg.height()) / 2 ).front();

    },

   
};


$('#text, #textbefore, #textafter').bind('input propertychange', bigright.draw);


