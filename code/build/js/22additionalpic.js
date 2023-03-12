var addPic1 = {
  svg: draw.circle(0),
  circleMask: draw.circle(0),
  pic: draw.circle(0),
  caption: draw.text(''),
  i: 1,
  font: {
    family: 'PT Sans',
    anchor: 'left',
    leading: '1.05em',
    size: 20,
  },

  draw() {
    this.svg.remove();
    this.svg = draw.group().addClass('draggable').attr('id', `addpic${this.i}`).draggable();

    this.svg.on('dragmove.namespace', () => {
      this.circleMask.move(this.pic.x(), this.pic.y());
    });

    this.svg.on('dragend.namespace', () => {
      $(`#addPic${this.i}x`).val(Math.round(this.svg.x()));
      $(`#addPic${this.i}y`).val(Math.round(this.svg.y()));
      this.setCaption();
    });

    this.circleMask = draw.circle(0).fill({ color: '#fff' });

    this.pic = draw.image($(`#addpicfile${this.i}`).val(), () => {
      this.circleMask.size(0);

      this.svg.add(this.pic);
      this.svg.move($(`#addPic${this.i}x`).val(), $(`#addPic${this.i}y`).val());

      this.resize();
      this.setMask();

      this.setCaption();
    });
  },

  setCaption() {
    const caption = $(`#addPicCaption${this.i}`).val();
    if (caption === '') {
      return;
    }

    this.caption.remove();

    this.caption = draw.text(caption)
      .font(this.font)
      .fill($(`#addPicCaptionColor${this.i}`).val())
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    const pos = $(`#addPicCaptionPosition${this.i}`).val();

    switch( pos ) {
      case 'bottom':
        this.caption.move(this.svg.x(), this.svg.y() + this.svg.height() + 8);
        break;
      case 'right':
        this.caption.move(this.svg.x() + this.svg.width() + 8, this.svg.y() + this.svg.height() / 2 - this.caption.bbox().h / 2);
        break;
    }
  },

  changeCaptionPosition() {
    const pos = $(`#addPicCaptionPosition${this.i}`).val();
    const newPos = pos === 'bottom' ? 'right' : 'bottom';
    
    $(`#addPicCaptionPosition${this.i}`).val(newPos);
   
    this.setCaption();
  },

  setMask() {
    if (!$(`#addpicrounded${this.i}`).prop('checked')) {
      this.pic.unmask();
      return;
    }

    const radius = Math.min(this.pic.width(), this.pic.height()) / 2;
    const picCenter = { x: this.pic.width() / 2, y: this.pic.height() / 2 };

    this.circleMask.move(picCenter.x, picCenter.y).radius(radius - 3).back();
    this.pic.maskWith(this.circleMask);

    this.circleMask.move(this.pic.x(), this.pic.y());
  },

  setRoundBorder() {
    if (!$(`#addpicroundedborder${this.i}`).prop('checked')) {
      this.circleBorder.remove();
      return;
    }

    const diameter = Math.min(this.svg.width(), this.svg.height());

    this.circleBorder = draw.circle(diameter)
      .fill({ opacity: 0 })
      .stroke({ width: this.svg.width() / 45, color: '#fff' })
      .move(this.svg.x(), this.svg.y())
      .front();

    this.svg.add(this.circleBorder);
  },

  delete() {
    this.svg.remove();
    this.svg = draw.circle(0);
    this.caption.remove();
    this.caption = draw.circle(0);
    hide(`add-pic-tools-${this.i}`);
    $(`#addPic${this.i}x`).val('');
    $(`#addPic${this.i}y`).val('');
    $(`#addPicSize${this.i}`).val('');
  },

  resize() {
    this.svg.size(parseInt($(`#addPicSize${this.i}`).val(), 10), null);
    this.setCaption();
  },

  sameWidth() {
    this.svg.size(addPic1.svg.width(), null);
    $(`#addPicSize${this.i}`).val(this.svg.width());
    this.setCaption();
  },

  sameHeight() {
    this.svg.size(null, addPic1.svg.height());
    $(`#addPicSize${this.i}`).val(this.svg.width());
    this.setCaption();
  },

  sameY() {
    const y = addPic1.svg.y();
    this.svg.y(y);
    $(`#addPic${this.i}y`).val(y);
    this.setMask();
    this.setCaption();
  },

  sameX() {
    const x = addPic1.svg.x();
    this.svg.x(x);
    $(`#addPic${this.i}x`).val(x);
    this.setMask();
    this.setCaption();
  },

  setHighlight() {
    $('#highlight-rect')
      .removeClass('d-none')
      .css('top', `${this.svg.y()}px`)
      .css('left', `${this.svg.x()}px`)
      .css('width', `${this.svg.width()}px`)
      .css('height', `${this.svg.height()}px`);
  },

};

function unsetAddPicHighlight() {
  $('#highlight-rect').addClass('d-none');
}

for(let i = 1; i <= 5; i++) {

  $('#addPicSize' + i).bind('input propertychange', () => { window[`addPic${i}`].resize(); });
  $('#addpicrounded' + i).bind('change', () => { window[`addPic${i}`].draw(); });
  $('#addpicroundedborder' + i).bind('change', () => { window[`addPic${i}`].setRoundBorder(); });
  $('#addPicCaption' + i).bind('input propertychange', () => { window[`addPic${i}`].setCaption(); });
  $('#addpicdelete' + i).bind('click', () => { window[`addPic${i}`].delete(); });
  $('.show-add-pic-' + i).mouseover(() => { window[`addPic${i}`].setHighlight(); });
  $('.addPicCaptionPositionButton' + i).bind('click', () => { window[`addPic${i}`].changeCaptionPosition(); });
  

  if( i === 1 ) continue;
  window[`addPic${i}`] = { ...addPic1 };
  window[`addPic${i}`].i = i;
  
  $('.addpic-same-width-' + i).bind('click', () => { window[`addPic${i}`].sameWidth(); });
  $('.addpic-same-height-' + i).bind('click', () => { window[`addPic${i}`].sameHeight(); });
  $('#addpic-same-x-' + i).bind('click', () => { window[`addPic${i}`].sameX(); });
  $('#addpic-same-y-' + i).bind('click', () => { window[`addPic${i}`].sameY(); });
}

$('.show-add-pic-all').mouseout(() => { unsetAddPicHighlight(); });
