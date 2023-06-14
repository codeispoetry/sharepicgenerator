/* eslint-disable no-undef */
var inFloatingDraw = 0;
const floating = {
  svg: draw.text(''),
  shadow: draw.text(''),
  bottomFond: draw.text(''),
  align: 'left',
  font: {
    family: 'Poppins',
    anchor: 'left',
    leading: '1.05em',
    size: 20,
    weight: 'bold',
    style: 'italic',
  },
  fontBefore: {
    family: 'Poppins',
    anchor: 'left',
    leading: '1.05em',
    weight: 'bold',
    size: 10,
  },
  fontAfter: {
    family: 'Poppins',
    anchor: 'left',
    leading: '1.05em',
    size: 10,
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
    
    const anchor = $('#textFloating').val();

    const elemMainText = draw.text(text)
      .font(Object.assign(floating.font, { anchor }))
      .fill($('#textcolor').val())
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    
    let nextY = 0;
    let w = 0;
    let h = 0;

    if ($('#textbefore').val()) {
      var elemTextBefore = floating.drawTextBefore();
      elemTextBefore.y(0);
      nextY += elemTextBefore.bbox().height;
      h += elemTextBefore.bbox().height;
      w = Math.max(w, elemTextBefore.bbox().width);
    }

    elemMainText.y(nextY);
    nextY += elemMainText.bbox().height;
    h += elemMainText.bbox().height;
    w = Math.max(w, elemMainText.bbox().width);
   
    if ($('#textafter').val()) {
      var elemTextAfter = floating.drawTextAfter();
      elemTextAfter.y(nextY)
      nextY += elemTextAfter.bbox().height;
      h += elemTextAfter.bbox().height;
      w = Math.max(w, elemTextAfter.bbox().width);
    }

    if ($('#claimtext').val()) {
      var elemClaimText = floating.drawClaim();
      const claimTextOffset = 5; 
      elemClaimText.y(nextY + claimTextOffset)
      h += elemClaimText.bbox().height + claimTextOffset;
      w = Math.max(w, elemClaimText.bbox().width);
    }
   
    floating.svg.add(elemMainText);
    floating.svg.add(elemTextBefore);
    floating.svg.add(elemTextAfter);
    floating.svg.add(elemClaimText);

    floating.scale(false);

    floating.shadow.remove();
    if ( $('#textShadow').prop('checked') ) {
      floating.drawShadow();
    }

    floating.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10 ));

    if (!$('#advancedmode').prop('checked')) {
      const scaleFactor = parseInt($('#textsize').val(), 10) / 100;
      defaultlogo.setSize(17 * scaleFactor * 1.7);
      pin.setSize(17 * scaleFactor * 1.7 * 1.15);
    }

    floating.svg.front();

    floating.bottomFond.remove();
    if ( $('#bottomVariant').prop('checked') ) {
      floating.setBottomVariant();
    }
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

  drawClaim(t) {
    const claim = draw.group();

    let textColor = '#FFFFFF';
    if ($('#claimcolor').val() === '#ffe100') {
      textColor = '#145f32';
    }

    const textInClaim = $('#claimtext').val();

    const claimText = draw.text(textInClaim)
      .font({
        family: 'BereitBold',
        anchor: 'left',
        leading: '1.05em',
        size: 8,
      })
      .move(2, 1)
      .fill(textColor);

    // if (textInClaim.includes('Ä') || textInClaim.includes('Ö') || textInClaim.includes('Ü')) {

    const claimBackground = draw.rect(claimText.bbox().w + 4, 11.5)
      .fill($('#claimcolor').val())
      .skew(-8, 0)
      .addTo(claim);

    claimText.addTo(claim);

    let x;
    switch ($('#textFloating').val()) {
      case 'middle':
        x = -claim.width() / 2;
        break;
      case 'end':
        x = -claim.width();
        break;
      default:
        x = 0;
    }

    claim.dx(x);

    return claim;
  },

  drawTextBefore() {
    let content = $('#textbefore').val();
    let color = $('#textbeforecolor').val() || '#FFFFFF';
    let font = floating.fontBefore;

    const textbefore = draw.text(content)
      .font(font)
      .fill(color)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    switch ($('#textFloating').val()) {
      case 'middle':
        textbefore.x(-textbefore.bbox().w / 2);
        break;
      case 'end':
        textbefore.x(-textbefore.bbox().w);
        break;
      default:
    }

    return textbefore;
  },

  drawTextAfter() {
    const textafter = draw.text($('#textafter').val())
      .font(floating.fontAfter)
      .fill($('#textaftercolor').val() || '#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    switch ($('#textFloating').val()) {
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

  setBottomVariant() {
    const padding = 20;
    const y =  draw.height() - floating.svg.height() - padding;

    floating.bottomFond = draw.rect(draw.width(), floating.svg.height() + 2 * padding)
      .fill('#A0C864')
      .move(0, y - padding);

    floating.svg.move(padding, y).front();
  }
};

$('#text, #textafter, #textbefore, #claimtext, #textShadow, #textscaled, #bottomVariant').bind('input propertychange', floating.draw);

$('.textscale').click(function () {
  $('#textscaled').val($('#textscaled').val() * parseFloat($(this).data('scale'), 10));
  floating.draw();
  undo.save();
});


$('#text, #textafter, #textbefore, #claimtext, .change-text, #textShadow, #textscaled, #bottomVariant').change(() => {
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
