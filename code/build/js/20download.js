$('#download').click(function(){
    let data = svg.svg();

    $.ajax({
        type: "POST",
        url: 'savesvg.php',
        data: { svg: data },
        success: function ( data ){
              console.log("aus savesvg.php kam: " + data )
            url = 'download.php?file=' + data;

          window.location.href = url;
        }
      });
})