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

  draw(i) {
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
    floating.scale(false, i);
  },

  scale(factor = false, i) {
    if( !factor ) {  
      factor = parseFloat($('#textscaled').val(), 10);
    } 

    floating[`svg${i}`]
      .scale(
        factor,
        parseInt($('#textX' + i).val(), 10), 
        parseInt($('#textY' + i).val(), 10)
      );
  },

};
$('.text-trigger').bind('input propertychange', () => {
  floating.draw(1);
  floating.draw(2);
  floating.draw(3);
  
});

$('.textscale').click(function () {
  $('#textscaled').val($('#textscaled').val() * parseFloat($(this).data('scale'), 10));
  floating.scale(parseFloat($(this).data('scale'), 10), 1);
  floating.scale(parseFloat($(this).data('scale'), 10), 2);
  floating.scale(parseFloat($(this).data('scale'), 10), 3);

});

