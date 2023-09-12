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
      
      $('select.detext').hide();
      $('option', '.lineColorSet').prop('disabled', false);
      usedColorSets = new Set();

      lines.forEach((value, index) => {
        if( value === '' ) return;

        $('select#lineColorSet' + index).show();
        const colorCombi = $('select#lineColorSet' + index).val().replace('/', '');
        
        $('select#lineColorSet' + index).removeClass('sandtanne');
        $('select#lineColorSet' + index).removeClass('tannesand ');
        $('select#lineColorSet' + index).removeClass('kleesand');
        $('select#lineColorSet' + index).removeClass('sandklee');
        $('select#lineColorSet' + index).removeClass('grashalmtanne');
        $('select#lineColorSet' + index).removeClass('tannegrashalm');

        $('select#lineColorSet' + index).addClass(colorCombi);

        $('select#lineSize' + index).show();

        const line = draw.group();
        const indentation = value.match(/^\s*/)[0].length;
        const size = $('#lineSize' + index).val();

        const colors = {
            'tanne' : '#005437',
            'klee' : '#008939',
            'grashalm' : '#8abd24',
            'sand' : '#f5f1e9',
        }
  
        usedColorSets.add($('#lineColorSet' + index).val());

        if( usedColorSets.size == 2 ) {
            const useColorSetsArray = [...usedColorSets];
            $(`option:not([value="${useColorSetsArray[0]}"]):not([value="${useColorSetsArray[1]}"])`, 'select.lineColorSet').prop('disabled', true)
        }

        const colorNames = $('#lineColorSet' + index).val().split('/')
        let textColor = colors[colorNames[0]];
        let fondColor = colors[colorNames[1]];
  
        const text = line.text(value.replace(/^\s*/, ''))
          .font(Object.assign(detext.font, { size }))
          .fill(textColor)
          .move(0, 0)
          .attr('xml:space', 'preserve')
          .attr('style', 'white-space:pre');
  
        
          // letter M in size S
        let fondPaddingL = -1.9
        let fondPaddingR = -2.5
        let fondPaddingT = -6;
        let fondPaddingB = -5;

          switch (size) {
            case '30': // letter M in size M
              fondPaddingL = -3.3
              fondPaddingR = -3.25
              fondPaddingT = -8.5
              fondPaddingB = -7
            break;
            case '40': // letter M in size L
              fondPaddingL = -3.8
              fondPaddingR = -4
              fondPaddingT = -12
              fondPaddingB = -9
            break;
          }

        const fondW = text.bbox().width + (fondPaddingL + fondPaddingR);
        const fondH = text.bbox().height + (fondPaddingT + fondPaddingB);
        const fond = line
          .rect( fondW, fondH )
          .fill(fondColor)
          .skew(-12,0)
          .back();

        text.x(fondPaddingL).y(fondPaddingT)
  
        line
            .x(indentation * 5)
            .y(fondPaddingT + yOffset)
  
        yOffset += fond.height();
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
  