function save(){
    let data = $('#pic').serialize();

    $.post( "save.php", { user: config.user,data: data, accesstoken: config.accesstoken })
    .done(function( data ) {
        console.log( data)
    });
}
function load(){
    $.post( "get.php", { user: config.user, action: 'getSavedPic', accesstoken: config.accesstoken })
    .done(function( data ) {
        let response = JSON.parse( data );
        let formdata = JSON.parse( response.data );
        for(var elem in formdata) {
            $('#' + elem).val( formdata[ elem ]);
        }
    });
}