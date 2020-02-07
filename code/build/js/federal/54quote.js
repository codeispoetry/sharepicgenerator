const quote = {
    svg: draw.text(''),
    grayBackground: draw.circle(0),
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
            text.positionGrayBackground();
        });

        let y = 0;
       
        //let lines = '„' + $('#text').val() + '“';
        
        let lines = $('#text').val();
        let quotationMarks = ['„','“' ];
        let qmI = 0;
        while( (lines.match(/\"/g) || []).length ){
            lines = lines.replace(/\"/, quotationMarks[ qmI ]);
            qmI = (qmI + 1 ) % 2;
        }

        lines = lines.replace(/\n$/,'').split(/\n/);
        let fontfamily = 'Arvo';
 
        let lineBeginsY = [];
        let linesRendered = []; 
        let color;

        lines.forEach(function (value, index, array) {
                let style = 1;

                // the main text
                values = value.split(/\[|\]/);


                let t = draw.text(function (add) {
                    for(let i = 0; i<values.length; i++) {
                        style = (style == 0 ) ? 1 : 0;

                        color = quote.colors[style];
                        if(style == 0 ){
                            color = textColors[ $('#textColor').val() ];
                        }

                        add.tspan( values[i] ).fill(color).font(Object.assign( quote.font,{family: fontfamily}));
                        
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
        if( $('#textafter').val().length > 0 ){
            let lineWidth = text.svg.width() * 0.5;
            let lineOffset = (text.svg.width() - lineWidth ) / 2 ;  
            let lineafter = draw.rect( lineWidth, 1).fill( color ).dx( -1 * lineOffset ).dy( text.svg.height() + 4 );
            text.svg.add(lineafter);
        }

        // text below the line
        let textafterParts = $('#textafter').val().toUpperCase().split(/\[|\]/);
        style = 1;
        let textafter = draw.text(function (add) {
            for(let i = 0; i<textafterParts.length; i++) {
                style = (style == 0 ) ? 1 : 0;
                add.tspan( textafterParts[i] ).fill( color ).font(quote.fontoutsidelines);
                add.attr("xml:space","preserve");
                add.attr("style","white-space:pre");
            }
        });
        textafter.dy(text.svg.height() + 12);

        text.svg.add(textafter);

        // gray layer behind text
        text.grayBackground.remove();
        if ( $('#graybehindtext').prop("checked") ) {

            let grayGradient = draw.gradient('radial', function(add) {
                add.stop({ offset: 0, color: '#000', opacity: 0.9 });
                add.stop({ offset: 0.9, color: '#000', opacity: 0.0 });
            });
            grayGradient.from(0.5, 0.5).to(0.5, 0.5).radius(0.5);

            text.grayBackground = draw.rect(text.svg.width(), text.svg.height())
                .fill({color:grayGradient, opacity: 0.3})
                .back();
        }


        text.svg.move(parseInt($('#textX').val()), parseInt($('#textY').val())).size(parseInt($('#textsize').val()));
        text.positionGrayBackground();
    },

};


$('#text, #textafter, #textsize, #graybehindtext').bind('input propertychange', quote.draw);
