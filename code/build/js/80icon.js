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
    getIcons();
})


var localIconsLoaded = false;
function getIcons() {
    if( localIconsLoaded ){
        return;
    }
    let url = "geticons.php";
    $('#iconoverlay .results').html('loading');
    $.ajax({
        url: url,
        success: function (data, textStatus, jqXHR) {
            $('#iconoverlay .results').html('');
            let json = JSON.parse(data);
            json.hits.forEach(function (icon) {
                $('#iconoverlay .results').append( '<div class="chooseicon"><img src="' + icon + '" title="' + icon + '"/></div>' );
            });

            $('#iconoverlay .results .chooseicon').click( function(){
                $('#iconoverlay').removeClass("active");
                icon.load( $("img", this).attr("src") );
            } );

            localIconsLoaded = true;
        },
        error: function(data, textStatus, jqXHR) {
            console.log(data, jqXHR);
        }

    });
}
