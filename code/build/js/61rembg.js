const rembg = {
  svg: '',

  load(caller){
    $('#canvas').css('opacity',0.1);
    $('.rembg').toggleClass('d-none');
    $('.rembg-reset').toggleClass('d-none');

    $.ajax({
      type: 'POST',
      url: '/actions/rembg.php',
      data: {
        filename: JSON.stringify($('#fullBackgroundName').val()),
        csrf: config.csrf,
      },
      success(response) {
        $('#canvas').css('opacity', 1);
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
      $('#blur').val(2);
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

    if( config.formerFullBackgroundName !== undefined) {
      $('#fullBackgroundName').val(config.formerFullBackgroundName);
      delete config.formerFullBackgroundName;
      background.draw();
    }

    $('#blur').val(0);
    background.addFilter();

    $('.rembg').toggleClass('d-none');
    $('.rembg-reset').toggleClass('d-none');
  }
}


$('.rembg').click(function() {
    rembg.load($(this));
});

$('.rembg-reset').click(function() {
  rembg.reset();
});
