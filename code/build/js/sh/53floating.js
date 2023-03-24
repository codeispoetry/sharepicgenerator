/* eslint-disable no-undef */
var inFloatingDraw = 0;
const floating = {
  svg: draw.text(''),
  fond: draw.circle(0),
  fondPadding: 30,
  align: 'left',
  font: {
    family: 'Brandon Text',
    anchor: 'left',
    leading: '1.05em',
    'letter-spacing': '0.05em',
    size: 20,
    weight: 700,
  },
  fontBefore: {
    family: 'Brandon Text',
    anchor: 'left',
    leading: '1.05em',
    'letter-spacing': '0.05em',
    size: 10,
  },
  fontAfter: {
    family: 'Brandon Text',
    anchor: 'left',
    leading: '1.05em',
    'letter-spacing': '0.05em',
    weight: 700,
    size: 16,
  },

  draw() {
    let text = $('#text').val();
    if ($('#text').val() === '') {
      text = ' ';
    }

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.handeDragEvents();
    
    const anchor = $('#textFloating').val();

    const t = draw.text(text)
      .font(Object.assign(floating.font, { anchor }))
      .fill($('#textcolor').val())
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textafter').val()) {
      floating.svg.add(floating.drawTextAfter(t));
    }

    floating.svg.add(t);

    floating.drawClaim(t);

    if ($('#textbefore').val() || $('#layout-cite').prop('checked')) {
      floating.svg.add(floating.drawTextBefore());
    }

    floating.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10 ));

    floating.scale(false);

    if( $('#textShadow').prop('checked') ) {
      floating.addDarkBackground();
    }

    if (!$('#advancedmode').prop('checked')) {
      const scaleFactor = parseInt($('#textsize').val(), 10) / 100;
      defaultlogo.setSize(17 * scaleFactor * 1.7);
      pin.setSize(17 * scaleFactor * 1.7 * 1.15);
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

  drawClaim(t) {
    if ($('#claimtext').val() === '') {
      return;
    }

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

    claim.move(x, 8 + floating.svg.height() + 1 - 20);

    claim.addTo(floating.svg);
  },

  drawTextBefore() {
    let content = $('#textbefore').val();
    let color = $('#textbeforecolor').val() || '#FFFFFF';
    let font = floating.fontBefore;

    if ($('#layout-cite').prop('checked')) {
      content = ',,';
      color = '#FFFFFF';
      font = floating.fontCiteSymbol;
    }

    const textbefore = draw.text(content)
      .font(font)
      .fill(color)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textShadow').prop('checked')) {
      textbefore.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
        add.blend(add.$source, blur);
      });
    }

    textbefore.move(0, -20 - textbefore.bbox().h);

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

  drawTextAfter(t) {
   // claim.svg.hide();

    const textafter = draw.text($('#textafter').val())
      .font(floating.fontAfter)
      .fill($('#textaftercolor').val() || '#FFFFFF')
      .move(0, -20 + t.bbox().height)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textShadow').prop('checked')) {
      textafter.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
        add.blend(add.$source, blur);
      });
    }

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
};

$('#text, #textafter, #textbefore, #claimtext, #textShadow, #textscaled').bind('input propertychange', floating.draw);

$('.textscale').click(function () {
  $('#textscaled').val($('#textscaled').val() * parseFloat($(this).data('scale'), 10));
  floating.scale(parseFloat($(this).data('scale'), 10));
  undo.save();
});

$('#text, #textafter, #textbefore, #claimtext, .change-text, #textShadow').change(() => {
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
