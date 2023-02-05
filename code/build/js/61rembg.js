const rembg = {
  svg: '',

  load(caller){
    $('#canvas').css('opacity',0.1);

    $.ajax({
      type: 'POST',
      url: '/actions/rembg.php',
      data: {
        filename: JSON.stringify($('#fullBackgroundName').val()),
        bgcolor: JSON.stringify($('#backgroundcolor').val()),
        csrf: config.csrf,
      },
      success(response) {
        $('#canvas').css('opacity', 1);
        const data = JSON.parse(response);

        uploadFileByUrl(data.filename);
       },
      error(response) {
        console.log("error",response);
      },
    });
  }
}


$('.rembg').click(function() {
    rembg.load($(this));
});

