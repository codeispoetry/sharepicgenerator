/* eslint-disable no-undef */
var inFloatingDraw = 0;
const floating = {
  svg: draw.text(''),
  shadow: draw.text(''),
  bottomFond: draw.text(''),
  align: 'left',
  font: {
    family: 'Capitolium',
    anchor: 'middle',
    leading: '1.05em',
    size: 20,
    weight: 'normal',
  },

  draw() {
    let text = $('#text').val();
    if (text === '') {
      text = ' ';
    }

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.svg.on('dragstart.namespace', function () {
      undo.save();
    });

    floating.svg.on('dragend.namespace', function floatingDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
      floating.draw();
    });
    

    const lines = text.replace(/\n$/, '').split(/\n/);

    let lineY = 0;

    lines.forEach((value, index) => {

      let family = 'Capitolium';
      let size = 20;
    

      if (value.charAt(0) == '!') {
        family = 'Better Times';
        value = value.substring(1);
        size = 50;
      } 


      const elemMainText = draw.text(value)
        .font(Object.assign(floating.font, { family, size }))
        .move(0, lineY)
        .fill($('#textcolor').val())
        .attr('xml:space', 'preserve')
        .attr('style', 'white-space:pre');

      elemMainText.dx(-elemMainText.bbox().width / 2);

      floating.svg.add(elemMainText);

      lineY += 0.7 * elemMainText.bbox().height;
    }); 
    floating.scale(false);

    floating.shadow.remove();
    if ( $('#textShadow').prop('checked') ) {
      floating.drawShadow();
    }

    floating.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10 ));

    if (!$('#advancedmode').prop('checked')) {
      const scaleFactor = parseInt($('#textsize').val(), 10) / 100;
     
      pin.setSize(17 * scaleFactor * 1.7 * 1.15);
    }

    floating.svg.front();

    floating.bottomFond.remove();
  
  },

  scale(factor = false) {
    if( !factor ) {  
      factor = parseFloat($('#textscaled').val(), 10);
    } 

    const size = floating.svg.width() * factor;
    floating.svg.size(size);
   },

  drawShadow() {
    const w = floating.svg.width();
    const h = floating.svg.height();
    const padding = 120;
    floating.shadow.remove();

    const gradient = draw.gradient('radial', function(add) {
      add.stop({ offset: 0, color: '#000', opacity: 0.2 }) 
      //add.stop({ offset: 0.9, color: '#000', opacity: 0.6 }) 
      add.stop({ offset: 1, color: '#000', opacity: 0 }) 
    })

    const x = parseInt($('#textX').val(), 10) - padding;
    const y = parseInt($('#textY').val(), 10) -padding;

    floating.shadow = draw.rect(w + (2 * padding), h + (2  * padding))
      .fill(gradient)
      .opacity(1)
      .move(x, y);

  },

};

$('#text, #textShadow, #textscaled, #bottomVariant').bind('input propertychange', floating.draw);

$('.textscale').click(function () {
  $('#textscaled').val($('#textscaled').val() * parseFloat($(this).data('scale'), 10));
  floating.draw();
  undo.save();
});


$('#text, .change-text, #textShadow, #textscaled, #bottomVariant').change(() => {
  undo.save();
});

$('.text-align').click(function() {
  $('#textFloating').val($(this).data('align'));
  floating.draw();
  undo.save();
  }
);

$('.align-center-text').click(() => {
  const textWidth   = floating.svg.width();
  const textHeight  = floating.svg.height();
  $('#textX').val((draw.width() - textWidth) / 2);
  $('#textY').val((draw.height() - textHeight) / 2);
  floating.draw();
  undo.save();
});
