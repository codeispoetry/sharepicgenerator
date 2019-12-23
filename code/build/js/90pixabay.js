$('#pixabayopener').click(function () {
    $('#pixabay').addClass("active");
})

$('#pixabay form').submit(function () {
    getPixabayImages($('#pixabay .q').val());
    return false;
})

var page = 1;
function getPixabayImages(q) {
    let url = "https://pixabay.com/api/?key=" + config.pixabay.apikey + "&q=" + encodeURIComponent(q) + "&image_type=photo&page=" + page + "&per_page=100";

    $.ajax({
        url: url,
        success: function (data, textStatus, jqXHR) {
            $('#pixabay .results').html('');
            data.hits.forEach(function (image) {
                $('#pixabay .results').append('<img src="' + image.previewURL + '" data-url="' + image.largeImageURL + '">');
            });

            $('#pixabay .results>img').click( function(){
                uploadImageByUrl( $(this).data('url') );
            } );
        },
        error: function(data, textStatus, jqXHR) {
            console.log(data, jqXHR);
        }

    });
}
