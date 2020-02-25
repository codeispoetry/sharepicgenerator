const text = {
    svg: draw.text(''),
    grayBackground: draw.circle(0),
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
        if( config.layout !== undefined && config.layout !== "standard"){
            return; 
        }

        text.svg.remove();
        if( $('#text').val()=="" ) return;

        text.svg = draw.group().addClass('draggable').attr('id','svg-text').draggable();

        text.svg.on('dragmove.namespace', function (event) {
            $('.gridline-active').removeClass("gridline-active");

            let centerX = this.x() + ( this.width() / 2 );
            let centerY = this.y() + ( this.height() / 2 );
            let snapDistance = 5;

            if( Math.abs( (draw.width() * 0.5) - centerX ) < snapDistance ){
                $('#grid-vertical-center').addClass("gridline-active");
            }
            if( Math.abs( (draw.width() * 0.382 ) - centerX ) < snapDistance ){
                $('#grid-vertical-left').addClass("gridline-active");
            }
            if( Math.abs( (draw.width() * 0.618 ) - centerX ) < snapDistance ){
                $('#grid-vertical-right').addClass("gridline-active");
            }


            if( Math.abs( (draw.height() * 0.5 ) - centerY ) < snapDistance ){
                $('#grid-horizontal-center').addClass("gridline-active");
            }
            if( Math.abs( (draw.height() * 0.382 ) - centerY ) < snapDistance ){
                $('#grid-horizontal-upper').addClass("gridline-active");
            }
            if( Math.abs( (draw.height() * 0.618 ) - centerY ) < snapDistance ){
                $('#grid-horizontal-lower').addClass("gridline-active");
            }
        });

        text.svg.on('dragend.namespace', function (event) {
            $('#textX').val(Math.round(this.x()));
            $('#textY').val(Math.round(this.y()));
            text.bounce();
            text.positionGrayBackground();
            $('.gridline-active').removeClass("gridline-active");
        });

        let y = 0;

        let lines = $('#text').val();
        
        let quotationMarks = ['„','“' ];
        let qmI = 0;
        while( (lines.match(/\"/g) || []).length ){
            lines = lines.replace(/\"/, quotationMarks[ qmI ]);
            qmI = (qmI + 1 ) % 2;
        }
       
        lines = lines.replace(/\n$/,'').split(/\n/);

        let fontfamily = (lines.length <= 3) ? 'ArvoGruen' : 'Arvo';
        let longestLine = lines.reduce(function (a, b) { return a.length > b.length ? a : b; });

        let widthSameLineHeihgts = 16 * longestLine.length;

        let lineBeginsY = [];
        let linesRendered = []; 
        let color;

        lines.forEach(function (value, index, array) {
                let style = 1;

                // the main text
                if( lines.length < 4){
                    value = value.toUpperCase();
                }
                values = value.split(/\[|\]/);


                let t = draw.text(function (add) {
                    for(let i = 0; i<values.length; i++) {
                        style = (style == 0 ) ? 1 : 0;

                        color = text.colors[style];
                        if(style == 0 ){
                            color = textColors[ 0  ];
                            // always white, and not  $('#textColor').val()
                        }

                        add.tspan( values[i] ).fill( color ).font(Object.assign( text.font,{family: fontfamily}));
                        
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
        let iconHeightInLines = Math.min(lines.length, parseInt( $('#iconsize').val() ) );

        if( icon.isLoaded ){
            licon = icon.svg.clone();
            licon.move(0,3).size(null, lineBeginsY[ iconHeightInLines - 1 ] - 3);
            text.svg.add( licon )

            for( let i = 0; i < iconHeightInLines; i++){
                linesRendered[ i ].dx( 1.15 * licon.width() );
            }
        }
        



        // add upper and lower line
        color = "white";
        let linebefore = draw.rect(text.svg.width(), 2).fill( color ).dy(-4);
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

    positionGrayBackground: function(){
        text.grayBackground.x(text.svg.x() ).y(text.svg.y()).size(parseInt($('#textsize').val()));
        text.grayBackground.transform({scale:2.5});
        background.svg.back();
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




$('#text, #textbefore, #textafter, #textsize, #textsamesize, #greenbehindtext, #graybehindtext').bind('input propertychange', text.draw);
