/* eslint-disable no-undef */
/* This file resides in build/free. It is symlinked*/

var inFloatingDraw = 0;
const floating = {
  svg: draw.text(''),
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

    if( $('#textShadow').prop('checked') ) {
      floating.addDarkBackground();
    }
    
    floating.svg.front();
  },

  scale(factor = false) {
    if( !factor ) {  
      factor = parseFloat($('#textscaled').val(), 10);
    } 

    floating.svg.scale(
        factor,
        floating.svg.x(), 
        floating.svg.y()
      );
  },

  handeDragEvents() {
    floating.svg.on('dragstart.namespace', function () {
      undo.save();
    });

    floating.svg.on('dragend.namespace', function floatingDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

  },

  addDarkBackground() {
    const x = floating.svg.x();
    const y = floating.svg.y();
    const w = floating.svg.width();
    const h = floating.svg.height();
    const padding = 100;

    const gradient = draw.gradient('radial', function(add) {
      add.stop({ offset: 0, color: '#000', opacity: 0.2 }) 
      add.stop({ offset: 0.8, color: '#000', opacity: 0 }) 
    })

    const rect = draw.rect(w + (2 * padding), h + (2  * padding))
      .move(x -padding, y - padding)
      .fill(gradient)
      .opacity(1)
      .back();

    const cloneSvg = floating.svg.clone();
    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();
    floating.handeDragEvents();
    floating.svg.add(rect);
    floating.svg.add(cloneSvg);
  },

};

$('#text, #textShadow, #textcolor').bind('input propertychange', floating.draw);

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
