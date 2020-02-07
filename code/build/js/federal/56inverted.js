const inverted = {
    svg: draw.text(''),
    textbackground: draw.text(''),

    colors: ['#ffffff', '#ffee00'],
    lineheight: 20,
    linemargin: - 4,
    paddingLr: 5,
    font: {
        anchor: 'left',
        leading: '1.0em',
        size: 20
    },

    draw: function () {
        if( config.layout !== "inverted"){
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


        // the mask for text
        text.svg.move(parseInt($('#textX').val()), parseInt($('#textY').val())).size(parseInt($('#textsize').val()));

        let above = draw.rect(2000,1000).fill('white').move(-100, text.svg.y() - 1010);
        let below = draw.rect(2000,1000).fill('white').move(-100, text.svg.y() + text.svg.height() + 10 );
        let right = draw.rect(2000,1000).fill('white').move( text.svg.x() + text.svg.width() + 20, -500 );
        let left = draw.rect(2000,1000).fill('white').move(  text.svg.x() - 2020,  text.svg.y() -500 );
        let passepartout = draw.group();
        passepartout.add(above);
        passepartout.add(below);
        passepartout.add(left);
        passepartout.add(right);

        text.svg.add( passepartout );

        background.svg.maskWith(text.svg);
    },

 

};

$('#text, #textbefore, #textafter, #textsize, #textsamesize').bind('input propertychange', inverted.draw);
