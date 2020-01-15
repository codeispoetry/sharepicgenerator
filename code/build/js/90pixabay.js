$('#pixabayopener').click(function () {
    $('#pixabay').addClass("active");
});

$('.pixabay-picture').click(function () {
    getPixabayImages($('#pixabay .q').val());
});

$('.pixabay-video').click(function () {
    getPixabayVideos($('#pixabay .q').val());
});

var page = 1;

function getPixabayVideos( q ){
    console.log("Suche Videos für " + q);
}

function getPixabayImages(q) {
    let url = "https://pixabay.com/api/?key=" + config.pixabay.apikey + "&q=" + encodeURIComponent(q) + "&image_type=photo&page=" + page + "&per_page=100";

    $.ajax({
        url: url,
        success: function (data, textStatus, jqXHR) {
            $('#pixabay .results').html('');
            data.hits.forEach(function (image) {
                $('#pixabay .results').append('<img src="' + image.previewURL + '" data-url="' + image.largeImageURL + '" data-user="' + image.user + '">');
            });

            $('#pixabay .results>img').click( function(){
                let pixabayAttribution = $(this).data('user'); 
                uploadImageByUrl( $(this).data('url'), function(){
                    setCopyright( pixabayAttribution, 'pixabay');
                } );
            } );
        },
        error: function(data, textStatus, jqXHR) {
            console.log(data, jqXHR);
        }

    });
}
