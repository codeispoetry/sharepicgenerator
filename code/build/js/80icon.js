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

$('.chooseicon').on('click', function () {
    $('#iconoverlay').removeClass("active");
   icon.load( $("img", this).attr("src") );
});

$('#iconopener').click(function () {
    $('#iconoverlay').addClass("active");
})

