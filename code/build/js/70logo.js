var logo;


logo = draw.image('assets/sonnenblume.svg', function (event) {
    logo.size( 100,100 ).x( draw.width() - 110 ).y( 10 );
});


function setLogoPosition(){
    logo.x( draw.width() - logo.width() - 10 ).y( 10 );
}