$('#pixabayopener').click(function () {
    $('head meta[name="viewport"]').attr('content','width=device-width, initial-scale=1');

    $('#pixabay').addClass("active");
});


$('#pixabay-form').submit(function (e) {
    e.preventDefault();
    getPixabayImages($('#pixabay .q').val());
    return false;
});


var page = 1;

function getPixabayVideos( q ){
    console.log("Suche Videos für " + q);
    $('#videos-tab').tab('show');
    $('#pixabay-videos .results').html("Suche Videos ... ");

    let url = "https://pixabay.com/api/videos/?key=" + config.pixabay.apikey + "&q=" + encodeURIComponent(q) + "&page=" + page + "&per_page=100";

    $.ajax({
        url: url,
        success: function (data, textStatus, jqXHR) {
            $('#pixabay-videos .results').html('');
            data.hits.forEach(function (video) {
                $('#pixabay-videos .results').append('<img src="' + video.userImageURL + '" data-url="' + video.videos.medium.url + '" data-user="' + video.user + '" class="img-fluid">');
            });

            $('#pixabay-videos .results>img').click( function(){
                let pixabayAttribution = $(this).data('user');
                uploadImageByUrl( $(this).data('url'), function(){
                    setCopyright( pixabayAttribution, 'pixabay');

                    config.usePixabay = "pixabay";
                } );
            } );
        },
        error: function(data, textStatus, jqXHR) {
            console.log(data, jqXHR);
        }

    });

}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    e.target; // newly activated tab
    e.relatedTarget; // previous active tab
    let id=  $(e.target).attr('id');
    if( id == 'videos-tab'){
        getPixabayVideos( $('#pixabay .q').val() );
    }
});

function getPixabayImages(q) {
    let url = "https://pixabay.com/api/?key=" + config.pixabay.apikey + "&q=" + encodeURIComponent(q) + "&image_type=photo&page=" + page + "&per_page=100";

    $('#images-tab').tab('show');
    $('#pixabay-images .results').html("Suche Bilder ... ");
    
    $.ajax({
        url: url,
        success: function (data, textStatus, jqXHR) {
            $('#pixabay-images .results').html('');
            data.hits.forEach(function (image) {
                $('#pixabay-images .results').append('<img src="' + image.previewURL + '" data-url="' + image.largeImageURL + '" data-user="' + image.user + '" class="img-fluid">');
            });

            $('#pixabay-images .results>img').click( function(){
                let pixabayAttribution = $(this).data('user'); 
                uploadImageByUrl( $(this).data('url'), function(){
                    setCopyright( pixabayAttribution, 'pixabay');

                    config.usePixabay = "pixabay";
                } );
            } );
        },
        error: function(data, textStatus, jqXHR) {
            console.log(data, jqXHR);
        }

    });
}
