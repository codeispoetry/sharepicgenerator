const background = {
  svg: draw.circle(0),
  darklightlayer: draw.circle(0),
  greenlayer: draw.circle(0),
  colorlayer: draw.circle(0),
  shadow: draw.circle(0),

  isLoaded: false,

  draw() {
    this.svg.remove();

    const filename = $('#backgroundURL').val();

    this.svg = draw.image(filename, function drawImage() {
      this.back().draggable();
      background.isLoaded = true;
      background.resize();
      background.addFilter();

      background.svg.move(parseInt($('#backgroundX').val(), 10), parseInt($('#backgroundY').val(), 10));

      this.on('dragend.namespace', function dragEnd() {
        $('#backgroundX').val(Math.round(this.x()));
        $('#backgroundY').val(Math.round(this.y()));
        background.uncoveredAreaWarning();
      });

      // no dragging when nothing to drag
      this.draggable().on('beforedrag', (e) => {
        if (background.svg.width() === draw.width()
                    && background.svg.x() === 0
                    && background.svg.height() === draw.height()
                    && background.svg.y() === 0
        ) {
          e.preventDefault();
        }

        if (config.layout === 'invers') {
          e.preventDefault();
        }

        if (config.noBackgroundDragAndDrop) {
          e.preventDefault();
        }
      });

      // eslint-disable-next-line no-undef
      initSharepic();
    });
  },

  drawColor() {
    this.svg.remove();
    background.colorlayer.hide();
    this.svg = draw.rect(5000, 5000).fill($('#backgroundcolor').val()).back();
  },

  drawShadow() {
    this.shadow.remove();
    const gradient = draw.gradient('linear', function(add) {
      add.stop({ offset: 0, color: '#000', opacity: 0 })
      add.stop({ offset: 1, color: '#000', opacity: 0.7 })
    }).from(0, 0).to(0, 1)
    this.shadow = draw.rect(draw.width(), draw.height() * 0.3 ).move(0, draw.height() * 0.7).fill(gradient);
    if (typeof arrangeLayers === 'function') {
      arrangeLayers();
    }
  },

  addFilter() {
    background.svg.filterWith((add) => {
      add.colorMatrix('saturate', $('#saturate').val())
        .gaussianBlur($('#blur').val())
        .componentTransfer({
          type: 'linear', // will be set later
          slope: 0,
          intercept: 0,
        });
    });

    // because add.componentTransfer does not set tags in SVG
    $('feComponentTransfer *')
      .attr('type', 'linear')
      .attr('slope', $('#brightness').val())
      .attr('intercept', 0);
  },

  reset() {
    $('#backgroundX').val(0);
    $('#backgroundY').val(0);
    $('#saturate').val(1);
    $('#brightness').val(1);
    $('#blur').val(0);

    $('#greenify').prop('checked', false).change();

    $('#backgroundsize').val(parseInt($('#backgroundsize').prop('min'), 10));
    this.draw();
    background.uncoveredAreaWarning();
  },

  resize() {
    const val = parseInt($('#backgroundsize').val(), 10);
    this.svg.size(val);

    if (background.hasRoundingError()) {
      let size = parseInt($('#backgroundsize').val(), 10);
      $('#backgroundsize').val(size += 5);
      this.resize();
    }
    background.uncoveredAreaWarning();
  },

  hasRoundingError() {
    // -1 is for bug inkscape, see 15drawsize.js, standard y-position $('#backgroundY').val(-1);
    return (draw.height() - background.svg.height() > -1);
  },

  uncoveredAreaWarning() {
    if (!this.isLoaded) return false;

    let error = false;

    switch ($('#design').val()) {
      case 'bigright':
        if (this.svg.x() > 0) error = true;
        if (this.svg.y() > 0) error = true;
        if (this.svg.y() + this.svg.height() < draw.height()) error = true;
        break;
      default:
        if (this.svg.x() > 0) error = true;
        if (this.svg.x() + this.svg.width() < draw.width()) error = true;
        if (this.svg.y() > 0) error = true;
        if (this.svg.y() + this.svg.height() < draw.height()) error = true;
    }

    if (error) {
      message('Im Bild entsteht ein weißer Rand. Platziere das Bild neu, <u class="cursor-pointer" onClick="background.reset();">setze es zurück</u> oder vergrößere es.');
    } else {
      message();
    }
    return true;
  },
};

function greenify(brightness = 2.5, contrast = 0.05) {
  if (typeof greenifyMatrix === 'undefined') {
    greenifyMatrix = [
      0.359, 0, 0, 0, 0,
      0, 0.585, 0, 0, 0,
      0, 0, 0.129, 0, 0,
      0, 0, 0, 1, 0,
    ];
  }

  background.svg.filterWith((add) => {
    add.colorMatrix('saturate', 0)
      .componentTransfer({
        type: 'linear', // will be set later
        slope: 0,
        intercept: 0,
      })
      .colorMatrix('matrix', greenifyMatrix);
  });

  // because add.componentTransfer does not set tags in SVG
  $('feComponentTransfer *')
    .attr('type', 'linear')
    .attr('slope', brightness)
    .attr('intercept', contrast);
}

$('#backgroundreset').click(() => {
  background.reset();
});

$('#backgroundsize').bind('input propertychange', () => {
  background.resize();
});

$('#saturate, #brightness, #blur').bind('input propertychange', () => {
  $('#greenify').prop('checked', false).change();
  background.addFilter();
});

$('#backgroundflip').click(() => {
  $('#backgroundFlipped').val(($('#backgroundFlipped').val() === 'false') ? 'true' : 'false');
  background.svg.scale(-1, 1);
});

$('#backgroundcolor').bind('input propertychange', () => {
  background.drawColor();
});

$('#greenify').bind('change', () => {
  if ($('#greenify').prop('checked')) {
    greenify($('#greenifybrightness').val(), $('#greenifycontrast').val());
  } else {
    background.svg.unfilter();
    background.addFilter();
  }
});
$('#greenifybrightness, #greenifycontrast').bind('input propertychange', () => {
  greenify($('#greenifybrightness').val(), $('#greenifycontrast').val());
});

$('.greenifyreset').click(() => {
  $('#greenifybrightness').val(2.5);
  $('#greenifycontrast').val(0.05);
  greenify($('#greenifybrightness').val(), $('#greenifycontrast').val());
});
