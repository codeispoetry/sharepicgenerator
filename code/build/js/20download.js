$('#download').click(function(){
    $(this).prop("disabled", true);
    let description = $(this).html();
    $(this).html('... Augenblick bitte');

    let data = draw.svg();

    $.ajax({
        type: "POST",
        url: 'savesvg.php',
        data: { svg: data },
        success: function ( data ){
          let obj = JSON.parse( data );
          $(this).prop("disabled", false);
          $(this).html( description );
          window.location.href =  'download.php?file=' + obj.basename + '&width=' + info.originalWidth;
        }
      });
})