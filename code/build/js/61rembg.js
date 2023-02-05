const rembg = {
  image: '',

  load(){
    $.ajax({
      type: 'POST',
      url: '/actions/rembg.php',
      data: {
        filename: JSON.stringify($('#fullBackgroundName').val()),
        csrf: config.csrf,
      },
      success(response) {
        const data = JSON.parse(response);
        rembg.setImage(data.filename);
       },
      error(response) {
        console.log("error",response);
      },
    });
  },

  setImage(path){
    rembg.image = draw.image(path, function drawImage() {
      background.svg.hide();
      //background.drawColor();
      rembg.image
        .move(0,-1)
        .size(background.svg.width(), background.svg.height())
        .back();
      
      background.drawColor();
    });
  }
}


$('.rembg').click(function() {
    rembg.load();
});
