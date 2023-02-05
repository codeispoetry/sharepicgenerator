const rembg = {
  svg: '',

  load(caller){
    $('#canvas').css('opacity',0.1);

    const oldValue = $('.rembg').html();
    $('.rembg').html('<i class="fa fa-spinner fa-spin"></i> Augenblick bitte...');

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

        $('.rembg').html(oldValue);
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

