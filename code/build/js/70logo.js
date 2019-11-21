const logo = {
    isLoaded: false,

    svg: draw.image('assets/sonnenblume.svg', function (event) {
        logo.isLoaded = true;
    }),

    draw () {
        if (!logo.isLoaded ) return false;
        let width = Math.max(50, draw.width() * 0.10 );
        logo.svg.size(width).x(draw.width() - width - 10).y(10);
    }
};

