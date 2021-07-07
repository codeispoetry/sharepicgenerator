const background = {
  svg: draw.circle(0),
  darklightlayer: draw.circle(0),
  greenlayer: draw.circle(0),
  colorlayer: draw.circle(0),

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

      background.colorlayer.remove();
      background.colorlayer = draw.rect(draw.width(), draw.height()).fill('#A0C864').back().show();
    });
  },

  drawColor() {
    this.svg.remove();
    background.colorlayer.hide();
    this.svg = draw.rect(draw.width(), draw.height()).fill($('#backgroundcolor').val()).back();
  },

  addFilter() {
    this.svg.filterWith((add) => {
      add.colorMatrix('saturate', $('#graybackground').val())
        .gaussianBlur($('#blurbackground').val());
    });
  },

  reset() {
    $('#backgroundX').val(0);
    $('#backgroundY').val(0);
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

function greenify() {
  background.svg.filterWith((add) => {
    add.colorMatrix('saturate', 0)
      .componentTransfer({
        type: 'linear', // will be set later
        slope: 0,
        intercept: 0,
      })
      .colorMatrix('matrix', [
        0.359, 0, 0, 0, 0,
        0, 0.585, 0, 0, 0,
        0, 0, 0.129, 0, 0,
        0, 0, 0, 1, 0,
      ]);
  });

  // because add.componentTransfer does not set tags in SVG
  $('feComponentTransfer *')
    .attr('type', 'linear')
    .attr('slope', 2.5) // brightness
    .attr('intercept', 0.05); // contrast
}

$('#backgroundreset').click(() => {
  background.reset();
});

$('#backgroundsize').bind('input propertychange', () => {
  background.resize();
});

$('#graybackground, #blurbackground').bind('input propertychange', () => {
  background.addFilter();
});

$('#backgroundflip').click(() => {
  $('#backgroundFlipped').val(($('#backgroundFlipped').val() === 'false') ? 'true' : 'false');
  background.svg.scale(-1, 1);
});

$('#backgroundgreenify').click(() => {
  greenify();
});

$('#backgroundcolor').bind('input propertychange', () => {
  background.drawColor();
});
