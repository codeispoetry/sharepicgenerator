/* eslint-disable no-undef */
const subfloating = {
  svg: draw.text(''),
  shadow: draw.text(''),
  bottomFond: draw.text(''),
  align: 'left',
  font: {
    family: 'BereitBold',
    anchor: 'left',
    leading: '1.05em',
    size: 12,
  },


  draw() {
    let text = $('#textafter').val();
    if (text === '') {
      text = ' ';
    }

    subfloating.svg.remove();
    subfloating.svg = draw.group().addClass('draggable').draggable();

    subfloating.svg.on('dragstart.namespace', function () {
      undo.save();
    });

    subfloating.svg.on('dragend.namespace', function subfloatingDragEnd() {
      $('#text2X').val(Math.round(this.x()));
      $('#text2Y').val(Math.round(this.y()));
      subfloating.draw();
    });
    
 
    const elemMainText = draw.group();
 
    if ($('#textafter').val()) {
      var elemTextAfter = subfloating.drawTextAfter();  
    }

    subfloating.svg.add(elemTextAfter);
    subfloating.scale(false);

    subfloating.svg.move(parseInt($('#text2X').val(), 10), parseInt($('#text2Y').val(), 10 ));

    subfloating.svg.front();
  },

  scale(factor = false) {
   
    if( !factor ) {  
      factor = parseFloat($('#textscaled').val(), 10);
    } 
    
    const size = subfloating.svg.width() * factor;
    subfloating.svg.size(size);
   },

  drawTextAfter() {
    const textafter = draw.text($('#textafter').val())
      .font(subfloating.font)
      .fill($('#textaftercolor').val() || '#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    switch ($('#textsubfloating').val()) {
      case 'middle':
        textafter.x(-textafter.bbox().w / 2);
        break;
      case 'end':
        textafter.x(-textafter.bbox().w);
        break;
      default:
    }

    return textafter;
  },
};

$('#textafter,#textscaled').bind('input propertychange', subfloating.draw);

