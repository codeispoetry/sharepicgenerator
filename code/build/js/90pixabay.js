$('#pixabayopener').click(function () {
    $('#pixabay').addClass("active");
})

$('#pixabay>form').submit(function () {
    getPixabayImages($('#pixabay>form>.q').val());
    return false;
})


var pixabayAPIKey = "1309982-0e2df8b488eca18e61116743a";
var page = 1;

function getPixabayImages(q) {
    let url = "https://pixabay.com/api/?key=" + pixabayAPIKey + "&q=" + encodeURIComponent(q) + "&image_type=photo&page=" + page + "&per_page=50";

    $.ajax({
        url: url,
        success: function (data, textStatus, jqXHR) {
            $('#pixabay>.results').html('');
            data.hits.forEach(function (image) {
                $('#pixabay>.results').append('<img src="' + image.previewURL + '" data-url="' + image.largeImageURL + '">');
            });

            $('#pixabay>.results>img').click( function(){
                uploadImageByUrl( $(this).data('url') );
            } );
        }
    });
}

function uploadImageByUrl( url ) {

    $('#waiting').addClass('active');

    var request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.responseType = 'blob';
    request.onload = function () {
        let reader = new FileReader();
        reader.onload = function () {
            $.post("upload.php", {data: reader.result})
                .done(function (data) {
                    let obj = JSON.parse(data);
                    $('.overlay.active').removeClass('active');
                    afterUpload(obj);
                });

        };
        reader.readAsDataURL(request.response);
    };
    request.send();
}
