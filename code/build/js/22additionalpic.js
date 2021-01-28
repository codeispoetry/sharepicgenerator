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
    this.circleBorder = draw.circle(0).attr({ fill: 'transparent', stroke: '#fff' });

    this.pic = draw.image($(`#addpicfile${this.i}`).val(), () => {
      let radius = this.pic.height();
      if (this.pic.height() > this.pic.width()) {
        radius = this.pic.width();
      }

      if ($(`#addpicrounded${this.i}`).prop('checked')) {
        this.circleMask.move(this.pic.width() / 2, this.pic.height() / 2)
          .radius(radius / 2 - 3).back();
        this.pic.maskWith(this.circleMask);

        if ($(`#addpicroundedbordered${this.i}`).prop('checked')) {
          this.circleBorder.move(radius / 2, radius / 2)
            .radius(radius / 2 - 3);
          this.circleBorder.attr({ 'stroke-width': radius / 15 });
          this.svg.add(this.circleBorder);
        }
      } else {
        this.circleMask.size(0);
      }
      this.svg.add(this.pic);
      this.svg.move($(`#addPic${this.i}x`).val(), $(`#addPic${this.i}y`).val());

      this.resize();
      this.svg.move($(`#addPic${this.i}x`).val(), $(`#addPic${this.i}y`).val());
      this.setMask();
    });
  },

  setMask() {
    this.circleMask.move(this.pic.x(), this.pic.y());
  },

  delete() {
    this.svg.remove();
    this.svg = draw.circle(0);
    hide(`show-add-pic-${this.i}`);
    $(`#addPic${this.i}x`).val('');
    $(`#addPic${this.i}y`).val('');
    $(`#addPicSize${this.i}`).val('');
  },

  resize() {
    const percentage = (draw.width() * parseInt($(`#addPicSize${this.i}`).val(), 10)) / 100;
    this.svg.size(percentage);
  },

  clippingSetPosition() {
    this.pic.x($(`#addPicClipHorizontal${this.i}`).val());
    this.pic.size($(`#addPicClipWidth${this.i}`).val());
  },

};

// eslint-disable-next-line no-unused-vars
function addpicAlign() {
  const y = addPic1.svg.y();
  const size = (addPic1.pic.height() / addPic2.pic.height()) * $('#addPicSize1').val();
  $('#addPic2y').val(y);
  $('#addPicSize2').val(size);
  addPic2.draw();
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
$('#addpicrounded1').bind('change', () => { addPic1.draw(); });
$('#addpicroundedbordered1').bind('change', () => { addPic1.draw(); });
$('#addpicdelete1').bind('click', () => { addPic1.delete(); });
$('#addPicClipHorizontal1, #addPicClipWidth1').bind('input propertychange', () => { addPic1.clippingSetPosition(); });

$('#addPicSize2').bind('input propertychange', () => { addPic2.resize(); });
$('#addpicrounded2').bind('change', () => { addPic2.draw(); });
$('#addpicroundedbordered2').bind('change', () => { addPic2.draw(); });
$('#addpicdelete2').bind('click', () => { addPic2.delete(); });

$('#addPicSize3').bind('input propertychange', () => { addPic3.resize(); });
$('#addpicrounded3').bind('change', () => { addPic3.draw(); });
$('#addpicroundedbordered3').bind('change', () => { addPic3.draw(); });
$('#addpicdelete3').bind('click', () => { addPic3.delete(); });

$('#addPicSize4').bind('input propertychange', () => { addPic4.resize(); });
$('#addpicrounded4').bind('change', () => { addPic4.draw(); });
$('#addpicroundedbordered4').bind('change', () => { addPic4.draw(); });
$('#addpicdelete4').bind('click', () => { addPic4.delete(); });

$('#addPicSize5').bind('input propertychange', () => { addPic5.resize(); });
$('#addpicrounded5').bind('change', () => { addPic5.draw(); });
$('#addpicroundedbordered5').bind('change', () => { addPic5.draw(); });
$('#addpicdelete5').bind('click', () => { addPic5.delete(); });
