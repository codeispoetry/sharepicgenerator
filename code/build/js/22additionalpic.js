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
      let radius = this.pic.height();
      if (this.pic.height() > this.pic.width()) {
        radius = this.pic.width();
      }

      if ($(`#addpicrounded${this.i}`).prop('checked')) {
        this.circleMask.move(this.pic.width() / 2, this.pic.height() / 2)
          .radius(radius / 2 - 3).back();
        this.pic.maskWith(this.circleMask);
      } else {
        this.circleMask.size(0);
      }
      this.svg.add(this.pic);
      this.svg.move($(`#addPic${this.i}x`).val(), $(`#addPic${this.i}y`).val());

      this.resize();
      this.svg.move($(`#addPic${this.i}x`).val(), $(`#addPic${this.i}y`).val());
      this.setMask();

      text.svg.front();
    });
  },

  setMask() {
    this.circleMask.move(this.pic.x(), this.pic.y());
  },

  delete() {
    this.svg.remove();
    this.svg = draw.circle(0);
    hide(`show-add-pic-${this.i}`);
  },

  resize() {
    const percentage = (draw.width() * parseInt($(`#addPicSize${this.i}`).val(), 10)) / 100;
    this.svg.size(percentage);
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

$('#addPicSize1').bind('input propertychange', () => { addPic1.resize(); });
$('#addpicrounded1').bind('change', () => { addPic1.draw(); });
$('#addpicdelete1').bind('click', () => { addPic1.delete(); });

$('#addPicSize2').bind('input propertychange', () => { addPic2.resize(); });
$('#addpicrounded2').bind('change', () => { addPic2.draw(); });
$('#addpicdelete2').bind('click', () => { addPic2.delete(); });
