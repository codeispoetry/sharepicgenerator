function save(){
    let data = $('#pic').serialize();

    $.post( "../save.php", { user: config.user,action: 'save',data: data, accesstoken: config.accesstoken })
    .done(function( data ) {
        $('#load').removeClass('d-none');
        $('#delete').removeClass('d-none');
        $('.saving-response').html("Gespeichert.").delay(2000).fadeOut();
    });
}

function unlink(){
    if( !confirm("Zwischenspeicherung wirklich löschen?")){
        return;
    }

    $.post( "../save.php", { user: config.user,action: 'delete', accesstoken: config.accesstoken })
    .done(function( data ) {
        $('.saving-response').html("Gelöscht.").delay(2000).fadeOut();
        $('#load').addClass('d-none');
        $('#delete').addClass('d-none');
    });
}


function load(){
    $.post( "../get.php", { user: config.user, action: 'getSavedPic', accesstoken: config.accesstoken })
    .done(function( data ) {
        let response = JSON.parse( data );
        let formdata = JSON.parse( response.data );

        if( !response.data){
            return false;
        }
        $('#load').removeClass('d-none');
        $('#delete').removeClass('d-none');

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
            icon.load();
        }, 100);


        window.setTimeout(function () {
            copyright.draw(); // unknow, why this has to be performed later
            pin.draw();
        }, 500);

    });
}