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

        //uploadImageByUrl( formdata[ "fullBackgroundURL" ]);


        // set the draw size manually, because it recalculates boundaries, etc.
        $('#width').val( formdata[ "width" ]);
        $('#height').val( formdata[ "height" ]);
        setDrawsize();



        for(var elem in formdata) {
            $('#' + elem).val( formdata[ elem ]);
        }

        let checkboxes = ["textsamesize","greenbehindtext"];
        checkboxes.forEach( function(elem){
            if( formdata[ elem ] === "on" ){
                $("#" + elem).prop('checked', true);
            }
        });



        window.setTimeout(function () {
            text.draw();
            logo.load();
            background.draw();
            copyright.draw();
            pin.draw();
        }, 100);


        window.setTimeout(function () {
            copyright.draw(); // unknow, why this has to be performed later
            pin.draw();
        }, 500);

    });
}