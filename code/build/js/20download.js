$('#download').click(function(){
    $(this).prop("disabled", true);
    let description = $(this).html();
    $(this).html('Augenblick bitte');

    let data = draw.svg();
    let format = 'png';
    
    $.ajax({
        type: "POST",
        url: 'createpic.php',
        data: { svg: data, format: format, width: info.originalWidth },
        success: function ( data, textStatus, jqXHR ){
          let obj = JSON.parse( data ); 
          $('#download').prop("disabled", false);
          $('#download').html( description);
  ;
          window.location.href =  'download.php?file=' + obj.basename + '&format=' + format;
        }
      });
})