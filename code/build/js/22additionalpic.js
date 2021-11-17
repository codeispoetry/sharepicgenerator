const addPic1 = {
  svg: draw.circle(0),
  circleMask: draw.circle(0),
  pic: draw.circle(0),
  i: 1,

  draw() {
    this.svg.remove();
    this.svg = draw.group().addClass('draggable').attr('id', `addpic${this.i}`).draggable();

    this.svg.on('dragmove.namespace', () => {
      this.circleMask.move(this.pic.x(), this.pic.y());
    });

    this.svg.on('dragend.namespace', () => {
      $(`#addPic${this.i}x`).val(Math.round(this.svg.x()));
      $(`#addPic${this.i}y`).val(Math.round(this.svg.y()));
    });

    this.circleMask = draw.circle(0).fill({ color: '#fff' });

    this.pic = draw.image($(`#addpicfile${this.i}`).val(), () => {
      this.circleMask.size(0);

      this.svg.add(this.pic);
      this.svg.move($(`#addPic${this.i}x`).val(), $(`#addPic${this.i}y`).val());

      this.resize();
      this.setMask();
    });
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
    hide(`add-pic-tools-${this.i}`);
    $(`#addPic${this.i}x`).val('');
    $(`#addPic${this.i}y`).val('');
    $(`#addPicSize${this.i}`).val('');
  },

  resize() {
    this.svg.size(parseInt($(`#addPicSize${this.i}`).val(), 10), null);
  },

  sameWidth() {
    this.svg.size(addPic1.svg.width(), null);
    $(`#addPicSize${this.i}`).val(this.svg.width());
  },

  sameHeight() {
    this.svg.size(null, addPic1.svg.height());
    $(`#addPicSize${this.i}`).val(this.svg.width());
  },

  sameY() {
    const y = addPic1.svg.y();
    this.svg.y(y);
    $(`#addPic${this.i}y`).val(y);
    this.setMask();
  },

  sameX() {
    const x = addPic1.svg.x();
    this.svg.x(x);
    $(`#addPic${this.i}x`).val(x);
    this.setMask();
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

const addPic2 = { ...addPic1 };
addPic2.i = 2;

const addPic3 = { ...addPic1 };
addPic3.i = 3;

const addPic4 = { ...addPic1 };
addPic4.i = 4;

const addPic5 = { ...addPic1 };
addPic5.i = 5;

$('#addPicSize1').bind('input propertychange', () => { addPic1.resize(); });
$('#addpicrounded1').bind('change', () => { addPic1.setMask(); });
$('#addpicroundedborder1').bind('change', () => { addPic1.setRoundBorder(); });
$('#addpicdelete1').bind('click', () => { addPic1.delete(); });
$('.show-add-pic-1').mouseover(() => { addPic1.setHighlight(); });

$('#addPicSize2').bind('input propertychange', () => { addPic2.resize(); });
$('#addpicrounded2').bind('change', () => { addPic2.draw(); });
$('#addpicroundedborder2').bind('change', () => { addPic2.setRoundBorder(); });
$('#addpicdelete2').bind('click', () => { addPic2.delete(); });
$('.addpic-same-width-2').bind('click', () => { addPic2.sameWidth(); });
$('.addpic-same-height-2').bind('click', () => { addPic2.sameHeight(); });
$('#addpic-same-x-2').bind('click', () => { addPic2.sameX(); });
$('#addpic-same-y-2').bind('click', () => { addPic2.sameY(); });

$('.show-add-pic-2').mouseover(() => { addPic2.setHighlight(); });

$('#addPicSize3').bind('input propertychange', () => { addPic3.resize(); });
$('#addpicrounded3').bind('change', () => { addPic3.draw(); });
$('#addpicroundedborder3').bind('change', () => { addPic3.setRoundBorder(); });
$('#addpicdelete3').bind('click', () => { addPic3.delete(); });
$('.addpic-same-width-3').bind('click', () => { addPic3.sameWidth(); });
$('.addpic-same-height-3').bind('click', () => { addPic3.sameHeight(); });
$('#addpic-same-x-3').bind('click', () => { addPic3.sameX(); });
$('#addpic-same-y-3').bind('click', () => { addPic3.sameY(); });
$('.show-add-pic-3').mouseover(() => { addPic3.setHighlight(); });

$('#addPicSize4').bind('input propertychange', () => { addPic4.resize(); });
$('#addpicrounded4').bind('change', () => { addPic4.draw(); });
$('#addpicroundedborder4').bind('change', () => { addPic4.setRoundBorder(); });
$('#addpicdelete4').bind('click', () => { addPic4.delete(); });
$('.addpic-same-width-4').bind('click', () => { addPic4.sameWidth(); });
$('.addpic-same-height-4').bind('click', () => { addPic4.sameHeight(); });
$('#addpic-same-x-4').bind('click', () => { addPic4.sameX(); });
$('#addpic-same-y-4').bind('click', () => { addPic4.sameY(); });
$('.show-add-pic-4').mouseover(() => { addPic4.setHighlight(); });

$('#addPicSize5').bind('input propertychange', () => { addPic5.resize(); });
$('#addpicrounded5').bind('change', () => { addPic5.draw(); });
$('#addpicroundedborder5').bind('change', () => { addPic5.setRoundBorder(); });
$('#addpicdelete5').bind('click', () => { addPic5.delete(); });
$('.addpic-same-width-5').bind('click', () => { addPic5.sameWidth(); });
$('.addpic-same-height-5').bind('click', () => { addPic5.sameHeight(); });
$('.show-add-pic-5').mouseover(() => { addPic5.setHighlight(); });
$('#addpic-same-x-5').bind('click', () => { addPic5.sameX(); });
$('#addpic-same-y-5').bind('click', () => { addPic5.sameY(); });

$('.show-add-pic-all').mouseout(() => { unsetAddPicHighlight(); });
