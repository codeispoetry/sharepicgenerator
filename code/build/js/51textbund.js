const text = {
    svg: draw.text(''),
    colors: ['#ffffff', '#ffee00'],
    lineheight: 20,
    linemargin: - 4,
    paddingLr: 5,
    font: {
        anchor: 'left',
        leading: '1.0em',
        size: 20
    },
    fontoutsidelines: {
        family: 'ArvoGruen',
        size: 10,
        anchor: 'left',
        leading: '1.0em',
    },


    draw: function () {

        text.svg.remove();
        if( $('#text').val()=="" ) return;

        text.svg = draw.group().addClass('draggable').draggable();

        text.svg.on('dragend.namespace', function (event) {
            $('#textX').val(Math.round(this.x()));
            $('#textY').val(Math.round(this.y()));
            text.bounce();
        });

        let y = 0;
        let lines = $('#text').val().replace(/\n$/,'').split(/\n/);
        let fontfamily = (lines.length <= 3) ? 'ArvoGruen' : 'Arvo';
        let longestLine = lines.reduce(function (a, b) { return a.length > b.length ? a : b; });

        let widthSameLineHeihgts = 16 * longestLine.length;

        let lineBeginsY = [];
        let linesRendered = []; 

        lines.forEach(function (value, index, array) {
                let style = 1;

                // the main text
                values = value.toUpperCase().split(/\[|\]/);

                let t = draw.text(function (add) {
                    for(let i = 0; i<values.length; i++) {
                        style = (style == 0 ) ? 1 : 0;
                        //add.tspan( values[i] ).fill(text.colors[style]).font({...text.font, ...{family: fontfamily}});
                        // Thanks to Edge, we cannot use lodash-syntax
                        add.tspan( values[i] ).fill(text.colors[style]).font(Object.assign( text.font,{family: fontfamily}));
                        
                        add.attr("xml:space","preserve");
                        add.attr("style","white-space:pre");
                    }
                });

                t.move(0, y );
              
                if( $('#textsamesize').prop("checked") ){
                    t = draw.group().add(t).size(widthSameLineHeihgts); // the number defines the size of the white bars
                }

                y += (t.rbox().h ) + text.linemargin ;

                lineBeginsY[ index ] = y;
                linesRendered[ index ] = t;
                text.svg.add(t);
            }
        );


        // Icon 
        let licon;
        let iconHeightInLines = parseInt( $('#iconsize').val() );

        if( icon.isLoaded ){
            licon = icon.svg.clone();
            licon.move(0,3).size(null, lineBeginsY[ iconHeightInLines - 1 ] - 3);
            text.svg.add( licon )

            for( let i = 0; i < iconHeightInLines; i++){
                linesRendered[ i ].dx( 1.15 * licon.width() );
            }
        }
        



        // add upper and lower line
        let linebefore = draw.rect(text.svg.width(), 2).fill('#ffffff').dy(-4);
        let lineafter = linebefore.clone().dy(text.svg.height() + 6);
        text.svg.add(linebefore);
        text.svg.add(lineafter);



        // text above and below the line
        let textbeforeParts = $('#textbefore').val().split(/\[|\]/);
        let style = 1;
        let textbefore = draw.text(function (add) {
            for(let i = 0; i<textbeforeParts.length; i++) {
                style = (style == 0 ) ? 1 : 0;
                add.tspan( textbeforeParts[i] ).fill(text.colors[style]).font(text.fontoutsidelines);
                add.attr("xml:space","preserve");
                add.attr("style","white-space:pre");
            }
        });
       textbefore.dy(-7);

        let textafterParts = $('#textafter').val().split(/\[|\]/);
        style = 1;
        let textafter = draw.text(function (add) {
            for(let i = 0; i<textafterParts.length; i++) {
                style = (style == 0 ) ? 1 : 0;
                add.tspan( textafterParts[i] ).fill(text.colors[style]).font(text.fontoutsidelines);
                add.attr("xml:space","preserve");
                add.attr("style","white-space:pre");
            }
        });
        textafter.dy(text.svg.height() + 7);

        text.svg.add(textbefore);
        text.svg.add(textafter);


        // green background behind text
        if ( $('#greenbehindtext').prop("checked") ) {
            let textbackgroundpadding = 10;
            //let textbackground = draw.rect(text.svg.width() + 2 * textbackgroundpadding, text.svg.height() + 2 * textbackgroundpadding).fill(draw.image('assets/bg_small.jpg',800,450    )).move(-textbackgroundpadding, -14).back();
            let textbackground = draw.rect(text.svg.width() + 2 * textbackgroundpadding, text.svg.height() + 2 * textbackgroundpadding)
            .fill('#46962b')
            .move(-textbackgroundpadding, -14).back();

            if ($('#textbefore').val()) {
                textbackground.dy(-9);
            }

            if ($('#textbefore').val() && $('#textafter').val()) {
                textbackground.height(textbackground.height() - 6);
            }

            text.svg.add(textbackground);
            textbackground.back();
        }

        text.svg.move(parseInt($('#textX').val()), parseInt($('#textY').val())).size(parseInt($('#textsize').val()));

       // pin.draw();
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


$('#text, #textbefore, #textafter, #textsize, #textsamesize, #greenbehindtext').bind('input propertychange', text.draw);
