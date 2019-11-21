$('#pixabayopener').click(function () {
    $('#pixabay').addClass("active");
})

$('#pixabay>form').submit(function () {
    getPixabayImages($('#pixabay .q').val());
    return false;
})


var pixabayAPIKey = "1309982-0e2df8b488eca18e61116743a";
var page = 1;

function getPixabayImages(q) {
    let url = "https://pixabay.com/api/?key=" + pixabayAPIKey + "&q=" + encodeURIComponent(q) + "&image_type=photo&page=" + page + "&per_page=100";
     url = '/dist/tmp/berge.json';
     console.log(url)
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
