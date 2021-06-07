const background = {
  svg: draw.circle(0),
  darklightlayer: draw.circle(0),
  greenlayer: draw.circle(0),

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

      background.addGreenLayer();
      background.addDarkLightLayer();

      // eslint-disable-next-line no-undef
      initSharepic();
    });
  },

  drawColor() {
    this.svg.remove();
    this.svg = draw.rect(draw.width(), draw.height()).fill($('#backgroundcolor').val()).back();
  },

  addGreenLayer() {
    this.greenlayer.remove();

    const value = $('#greenlayer').val() / 100;

    let color = $('#layerColor').val();
    if (!color) {
      color = '#46962b';
    }

    this.greenlayer = draw.rect(draw.width(), draw.height()).fill(color).opacity(value);

    this.greenlayer.attr('style', ' pointer-events: none;');

    this.darklightlayer.back();
    this.greenlayer.back();
    this.svg.back();
  },

  addDarkLightLayer() {
    this.darklightlayer.remove();

    let value = $('#darklightlayer').val() / 100;

    const color = (value > 0) ? 'black' : 'white';
    value = Math.abs(value);

    this.darklightlayer = draw.rect(draw.width(), draw.height()).fill(color).opacity(value);
    this.darklightlayer.attr('style', ' pointer-events: none;');

    this.darklightlayer.back();
    this.greenlayer.back();
    this.svg.back();
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

$('#backgroundreset').click(() => {
  background.reset();
});

$('#backgroundsize').bind('input propertychange', () => {
  background.resize();
});

$('#graybackground, #blurbackground').bind('input propertychange', () => {
  background.addFilter();
});

$('#darklightlayer').bind('input propertychange', () => {
  background.addDarkLightLayer();
});

$('#darklightlayer').dblclick(function dblClickLayer() {
  $(this).val(0);
  background.addDarkLightLayer();
});

$('#greenlayer').bind('input propertychange', () => {
  background.addGreenLayer();
});

$('#backgroundflip').click(() => {
  $('#backgroundFlipped').val(($('#backgroundFlipped').val() === 'false') ? 'true' : 'false');
  background.svg.scale(-1, 1);
});

$('#backgroundcolor').bind('input propertychange', () => {
  background.drawColor();
});
