const element = {
  
  svg: draw.circle(0),
 
  draw(clickElement) {
    const file = clickElement.data('file');
    //$('#elementsize').val( clickElement.data('width') );

    element.svg.remove();
    element.svg = draw.image(file, () => {
        element.svg.addClass('draggable').draggable();

        element.resize();
        element.svg.move(0, draw.height() - element.svg.height() + 1);

        floating.svg.front();
    });
  },

  resize() {
    const width = draw.width() * $('#elementsize').val() / 100;
    element.svg.size(width);
  }

};



$('.element').click(function() {
    element.draw($(this));
});

$('#elementsize').bind('input propertychange', () => {
    element.resize();
});
