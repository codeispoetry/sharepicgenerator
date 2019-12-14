const icon = {
    isLoaded: false,
   
    load(file = "assets/logos/sonnenblume-weiss.svg") {

        if (this.svg) this.svg.remove();
        icon.isLoaded = false;

      
        this.svg = draw.image(file, function (event) {
            icon.isLoaded = true;
            icon.svg.size(1).move(-100,-100); // cannot be resized to zero
            text.draw();
        });
    },

    remove(){
        if (this.svg) this.svg.remove();
        this.isLoaded = false;
    }
}

icon.load();

$('#iconsize').on('change', function () {
    if($(this).val() == 0){
        icon.remove();
    }
    text.draw();
});