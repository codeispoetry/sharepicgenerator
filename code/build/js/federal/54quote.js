const quote = {
    svg: draw.text(''),
    colors: ['#ffffff', '#ffee00'],
    lineheight: 20,
    linemargin: - 4,
    paddingLr: 5,
    font: {
        anchor: 'middle',
        leading: '1.0em',
        size: 20
    },
    fontoutsidelines: {
        family: 'Arvo',
        size: 10,
        anchor: 'middle',
        leading: '1.0em',
    },

    draw: function () {
        if( config.layout !== "quote"){
            return; 
        }

        text.svg.remove();
        if( $('#text').val()=="" ) return;

        text.svg = draw.group().addClass('draggable').attr('id','svg-text').draggable();

        text.svg.on('dragend.namespace', function (event) {
            $('#textX').val(Math.round(this.x()));
            $('#textY').val(Math.round(this.y()));
            text.bounce();
        });

        let y = 0;
        let textVal = '„' + $('#text').val() + '“'; 
        let lines = textVal.replace(/\n$/,'').split(/\n/);
        let fontfamily = 'Arvo';
 
        let lineBeginsY = [];
        let linesRendered = []; 

        lines.forEach(function (value, index, array) {
                let style = 1;

                // the main text
                values = value.split(/\[|\]/);


                let t = draw.text(function (add) {
                    for(let i = 0; i<values.length; i++) {
                        style = (style == 0 ) ? 1 : 0;
                        add.tspan( values[i] ).fill(quote.colors[style]).font(Object.assign( quote.font,{family: fontfamily}));
                        
                        add.attr("xml:space","preserve");
                        add.attr("style","white-space:pre");
                    }
                });

                t.y( y );
              
                y += (t.rbox().h ) + quote.linemargin ;

                lineBeginsY[ index ] = y;
                linesRendered[ index ] = t;
                text.svg.add(t);
            }
        );

        // add lower line
        let lineWidth = text.svg.width() * 0.5;
        let lineOffset = (text.svg.width() - lineWidth ) / 2 ;  
        let lineafter = draw.rect( lineWidth, 1).fill('#ffffff').dx( -1 * lineOffset ).dy( text.svg.height() + 4 );
        text.svg.add(lineafter);


        // text below the line
        let textafterParts = $('#textafter').val().toUpperCase().split(/\[|\]/);
        style = 1;
        let textafter = draw.text(function (add) {
            for(let i = 0; i<textafterParts.length; i++) {
                style = (style == 0 ) ? 1 : 0;
                add.tspan( textafterParts[i] ).fill(quote.colors[style]).font(quote.fontoutsidelines);
                add.attr("xml:space","preserve");
                add.attr("style","white-space:pre");
            }
        });
        textafter.dy(text.svg.height() + 12);

        text.svg.add(textafter);
        text.svg.move(parseInt($('#textX').val()), parseInt($('#textY').val())).size(parseInt($('#textsize').val()));

    },

    bounce: function () {
        if (this.svg.x() < 15) {
            $('#textX').val(15);
            this.draw();
        }
        if (this.svg.x() > draw.width() - this.svg.width() - 15) {
            $('#textX').val(draw.width() - this.svg.width() - 15);
            this.draw();
        }
        if (this.svg.y() < 30) {
            $('#textY').val(30);
            this.draw();
        }
        if (this.svg.y() > draw.height() - this.svg.height() - 30) {
            $('#textY').val(draw.height() - this.svg.height() - 30);
            this.draw();
        }
    },
};


$('#text, #textafter, #textsize').bind('input propertychange', quote.draw);
