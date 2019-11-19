$('#download').click(function(){
    //$(this).prop("disabled", true);

    let data = draw.svg();

    $.ajax({
        type: "POST",
        url: 'savesvg.php',
        data: { svg: data },
        success: function ( data ){
          let obj = JSON.parse( data );
          window.location.href =  'download.php?file=' + obj.basename 
            + '&pdf=false'
            + '&width=' + info.originalWidth;
        }
      });
})