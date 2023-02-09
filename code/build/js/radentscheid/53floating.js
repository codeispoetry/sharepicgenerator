/* eslint-disable no-undef */
const floating = {
  svg1: draw.text(''),
  svg2: draw.text(''),
  svg3: draw.text(''),
  fond: draw.circle(0),
  fondPadding: 30,
  align: 'left',
  font: {
    family: 'Bebas Neue',
    anchor: 'left',
    leading: '1.05em',
    size: 40,
  },

  draw(i = undefined) {
    if( isNaN(i) ) {
      i = $(this).attr('id')?.substr(-1) || 1;
    }

    floating[`svg${i}`].remove();
    floating[`svg${i}`] = draw.group().addClass('draggable').draggable();

    floating[`svg${i}`].on('dragend.namespace', function floatingDragEnd() {
      $('#textX' + i).val(Math.round(this.x()));
      $('#textY' + i).val(Math.round(this.y()));
    });

    const anchor = floating.align;
    const t = draw.text($(`#text${i}`).val())
      .font(Object.assign(floating.font, { anchor }))
      .fill($(`#textcolor${i}`).val())
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    floating[`svg${i}`].add(t);   

    floating[`svg${i}`].move($('#textX' + i).val(), $('#textY' + i).val());
    floating[`svg${i}`].front();

  },

  scale() {
    for(let i = 1; i <= 3; i++) {
      floating[`svg${i}`]
        .scale(
          $(this).data('scale'),
          parseInt($('#textX' + i).val(), 10), 
          parseInt($('#textY' + i).val(), 10)
        );
    }
  },

};
$('.text-trigger').bind('input propertychange', floating.draw);
$('.textscale').click(floating.scale);

