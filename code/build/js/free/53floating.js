/* eslint-disable no-undef */
/* This file resides in build/free. It is symlinked*/

var inFloatingDraw = 0;
const floating = {
  svg: draw.text(''),
  shadow: draw.text(''),
  font: {
    leading: '1.05em',
    size: 20,
  },

  draw() {
    let text = $('#text').val();
    if ($('#text').val() === '') {
      text = ' ';
    }

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.handeDragEvents();
    
    const family = $('#textFont').val();

    const t = draw.text(text)
      .font(Object.assign(floating.font, { family }))
      .fill($('#textcolor').val())
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    floating.svg.add(t);

    floating.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10 ));

    floating.scale(false);

    floating.shadow.remove();
    if ( $('#textShadow').prop('checked') ) {
      floating.drawShadow();
    }
    
    floating.svg.front();
  },

  scale(factor = false) {
    if( !factor ) {  
      factor = parseFloat($('#textscaled').val(), 10);
    } 

    const size = floating.svg.width() * factor;
    floating.svg.size(size);
  },

  handeDragEvents() {
    floating.svg.on('dragstart.namespace', function () {
      undo.save();
    });

    floating.svg.on('dragend.namespace', function floatingDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
      console.log( "Gespeichert", $('#textX').val(),  $('#textY').val() );
    });

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

$('#text, #textShadow, #textcolor, #textscaled').bind('input propertychange', floating.draw);

$('.textscale').click(function () {
  $('#textscaled').val($('#textscaled').val() * parseFloat($(this).data('scale'), 10));
  floating.scale(parseFloat($(this).data('scale'), 10));
  undo.save();
});

$('ul.font li').click(function () {
  $('#textFont').val($(this).data('font'));
  floating.draw();
});

$('#text, .change-text, #textShadow').change(() => {
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

$('.textShadowTrigger').click(() => {
  $('#textShadow').trigger('click');
});
