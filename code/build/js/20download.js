$('#download').click(function(){
    let data = draw.svg();

    $.ajax({
        type: "POST",
        url: 'savesvg.php',
        data: { svg: data },
        success: function ( data ){
          let obj = JSON.parse( data );
          window.location.href =  'download.php?file=' + obj.basename;
        }
      });
})