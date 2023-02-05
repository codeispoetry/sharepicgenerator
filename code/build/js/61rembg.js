const rembg = {
  svg: '',

  load(caller){
    $.ajax({
      type: 'POST',
      url: '/actions/rembg.php',
      data: {
        filename: JSON.stringify($('#fullBackgroundName').val()),
        csrf: config.csrf,
      },
      success(response) {
        const data = JSON.parse(response);
        const action = $(caller).data('rembg');
        eval(`rembg.${action}(data.filename)`);
       },
      error(response) {
        console.log("error",response);
      },
    });
  },

  remove(path){
    rembg.svg = draw.image(path, function drawImage() {
      background.svg.hide();
      rembg.svg
        .move(background.svg.x(),background.svg.y()) 
        .size(background.svg.width(), background.svg.height())
        .back();
      
      background.drawColor();
    });
  },

  blur(path){
    rembg.svg = draw.image(path, function drawImage() {
      $('#blur').val(3);
      background.addFilter();
      rembg.svg
        .move(background.svg.x(),background.svg.y())
        .size(background.svg.width(), background.svg.height())
        .front();
      
      $('.to-front').click();
    });
  },

  reset() {
    rembg.svg.remove();
    background.svg.show();
    $('#blur').val(0);
    background.addFilter();
  }
}


$('.rembg').click(function() {
    rembg.load($(this));
});

$('.rembg-reset').click(function() {
  rembg.reset();
});
