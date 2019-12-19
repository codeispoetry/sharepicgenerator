const icon = {
    isLoaded: false,
   
    load( file ) {
        if (this.svg) this.svg.remove();
        icon.isLoaded = false;

      
        this.svg = draw.image(file, function (event) {
            icon.isLoaded = true;
            icon.svg.size(1).move(-100,-100); // cannot be resized to zero
            text.draw();
        });

        this.svg.on('error', function(e){
            console.log( file, e );
        })
    },

    remove(){
        if (this.svg) this.svg.remove();
        this.isLoaded = false;
    }
}


$('#iconsize').on('change', function () {
    if($(this).val() == 0){
        icon.remove();
    }
    text.draw();
});



$('#iconopener').click(function () {
    $('#iconoverlay').addClass("active");
})

$('#iconoverlay form').submit(function () {
    getIcons( $('#iconoverlay .q').val());
    return false;
})


function getIcons( q ) {

    let url = "nounproject/load_results.php?q=" + q;
    $('#iconoverlay .results').html('suche Icons ');
    let loading = window.setInterval(function(){
        $('#iconoverlay .results').append(" . ");
    },10);
    $.ajax({
        url: url,
        success: function (data, textStatus, jqXHR) {
            $('#iconoverlay .results').html('');
            let json = JSON.parse(data);
    
           
            json.hits.forEach(function (icon) {
                $('#iconoverlay .results').append( '<div class="chooseicon" data-icon-url="' + icon.icon_url +'"><img src="' + icon.preview_url + '" title="' + icon.attribution + '"/></div>' );
            });

            if( json.hits.length == 0 ){
                $('#iconoverlay .results').append('<div class="col-12 bg-danger text-white p-3 text-center">Keine Icons gefunden. Bitte suche auf Englisch.</div>');
            }

            $('#iconoverlay .results .chooseicon').click( function(){
                $('#waiting').addClass('active');
                $('#iconoverlay').removeClass("active");

                $.get( "nounproject/get_icon.php", { icon_url: $(this).data("icon-url") } )
                    .done(function( data ) {
                        if( data == "error"){
                            console.log("error downloading icon");
                        }else{
                            icon.load( 'tmp/' + data );
                        }
                        $('#waiting').removeClass("active");

                 });
              
            } );

        
            window.clearInterval( loading );
        },
        error: function(data, textStatus, jqXHR) {
            console.log(data, jqXHR);
        }

    });
}
