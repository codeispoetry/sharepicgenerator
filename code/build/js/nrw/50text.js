const text = {
    svg: draw.text(''),
    lineheights: [26, 32],
    colors: ['#ffffff', '#46962b'],
    fontsizes: [23, 32],
    yBiases: [-4, -3],
    linemargin: 4,
    paddingLr: 5,
    font: {
        family: 'ArvoGruen',
        anchor: 'left', // right does not work as there a multiple text-entities
        leading: '1.25em',
        weight: 'normal'
    },


    draw: function () {


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

        lines.forEach(function (value, index, array) {
                let style = /^!/.test(value) ? 1 : 0;

                value = value.replace(/^!/, '');

                let textColor = textColors[ $('#textColor2').val() ];
                if( style ){
                    value = value.toUpperCase();
                    textColor = textColors[ $('#textColor1').val() ];
                }


                let t = draw.text(value).font(Object.assign(text.font, {size: text.fontsizes[style]})).fill(textColor).move(0, y + text.yBiases[style]);

                t.dx( -t.length() ); // align text right

                text.svg.add(t);
                y += text.lineheights[style] + text.linemargin;
            }
        );

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




$('#text, #textbefore, #textafter, #textsize').bind('input propertychange', text.draw);
