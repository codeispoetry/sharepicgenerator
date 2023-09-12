/* eslint-disable no-undef */
const detext = {
    svg: draw.text(''),
    align: 'left',
    font: {
      family: 'GrueneType',
      anchor: 'left',
      size: 20,
    },
  
    draw() {
      const lines = $('#text').val().replace(/\n$/, '').split(/\n/);
  
      detext.svg.remove();
      detext.svg = draw.group().addClass('draggable').draggable();
  
      detext.svg.on('dragend.namespace', function detextDragEnd() {
        $('#textX').val(Math.round(this.x()));
        $('#textY').val(Math.round(this.y()));
      });

      let yOffset = 0;
      
      $('.colorSetPicker').hide();
      $('.lineSizer').hide();
      $('.colorSetPicker .disabled').attr('title','');
      $('.colorSetPicker .disabled').removeClass('disabled');

      lines.forEach((value, index) => {
        if( value === '' ) return;

        $('#lineSizer' + index).show();
        $('#colorSetPicker' + index).show();

        const line = draw.group();
        const indentation = value.match(/^\s*/)[0].length;
        const size = $('#lineSize' + index).val();

        const colors = {
            'tanne' : '#005437',
            'klee' : '#008939',
            'grashalm' : '#8abd24',
            'sand' : '#f5f1e9',
        }
  
        // const disable = $('select#lineColorSet' + index + ' option:selected').data('disable');
        // if( disable ) {
        //   $(disable, 'select.lineColorSet').prop('disabled', true);
        // } 


        const colorNames = $('#lineColorSet' + index).val().split('/')
        let textColor = colors[colorNames[0]];
        let fondColor = colors[colorNames[1]];

        // check, if string "klee" is in colorNames
        if( colorNames.indexOf('klee') > -1 ) {
          $('.colorSetPicker .grashalm').addClass('disabled');
          $('.colorSetPicker .grashalm').attr('title', 'Es sind nur 2 Grüntöne gleichzeitig möglich.');

        }
        if( colorNames.indexOf('grashalm') > -1 ) {
          $('.colorSetPicker .klee').addClass('disabled');
          $('.colorSetPicker .klee').attr('title', 'Es sind nur 2 Grüntöne gleichzeitig möglich.');
        }
  
        const text = line.text(value.replace(/^\s*/, ''))
          .font(Object.assign(detext.font, { size }))
          .fill(textColor)
          .attr('xml:space', 'preserve')
          .attr('style', 'white-space:pre');
  
        
        // Set the paddings to 0, that means, 
        // the fond will be EXACTLY as big as the text
        // letter M in size S
        let fondPaddingL = 0
        let fondPaddingR = 0
        let fondPaddingT = -58
        let fondPaddingB = -46;

          switch (size) {
            case '300': // letter M in size M
              fondPaddingL = 0
              fondPaddingR = -0
              fondPaddingT = -86
              fondPaddingB = -71
            break;
            case '400': // letter M in size L
              fondPaddingL = 0
              fondPaddingR = 0
              fondPaddingT = -116
              fondPaddingB = -92
            break;
          }

        // 
        let fondW = text.bbox().width + fondPaddingL + fondPaddingR;
        let fondH = text.bbox().height + fondPaddingT + fondPaddingB;

        const fromSizeToRealHeight = size / 1.3333;
        const fondPaddingAround = fromSizeToRealHeight * 0.3;
        fondW += 2 * fondPaddingAround;
        fondH += 2 * fondPaddingAround;
        text.move(fondPaddingAround, fondPaddingAround)

        const skewFixer = fondH * Math.tan(12 * Math.PI / 180);
        const fond = line
          .rect( fondW - skewFixer, fondH )
          .fill(fondColor)
          .move(0, -fondPaddingT)
          .transform(
            {
              skew: [-12, 0],
              origin: 'bottom left',
            })
          .back();
  
        line
            .x(indentation * 5)
            .dy(fondPaddingT + yOffset)
  
        yOffset += fond.height() - 1;
        detext.svg.add(line);
      });
  
      detext.svg
        .size($('#textsize').val())
        .move($('#textX').val(), $('#textY').val());
  
      detext.svg.front();
    },
  
  
  };
  
  $('.detext').bind('input propertychange',  detext.draw);
  
  $('.align-center-text').click(() => {
    $('#textX').val((draw.width() - detext.svg.width()) / 2);
    $('#textY').val((draw.height() - detext.svg.height()) / 2);
    detext.draw();
  });

  var usedColorSets = new Set();
  