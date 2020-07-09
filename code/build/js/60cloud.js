function getCloudfiles(){

    $.ajax({
        type: "POST",
        url: '../nextcloudget.php',
        data: {
            user: config.user,
            accesstoken: config.accesstoken,
        },
        success: function (data, textStatus, jqXHR) {
            let obj = JSON.parse(data);

            if(obj.status == "500"){

                $('#cloudmessage').show();
                $('#cloudmessage p').html("Kein Zugang zur Cloud.");
                $('#cloudnotoken').show();
                return;
            }

            let count = obj.data.length;
            let sharepics =  '';
            switch(count){
                case 0:
                    sharepics = "Keine Sharepics";
                    break;
                case 1:
                    sharepics = "Ein Sharepic";
                    break;
                default:
                    sharepics = count + " Sharepics";

            }

            $("#cloudfiles option:first").html( sharepics + " in der Cloud:");
            $("#cloudfiles").prop("disabled",false);

            obj.data.forEach ( element => {
                $("#cloudfiles").append(new Option( basename(element), element ));
            });

            $('#cloudhastoken').show();
            $('#cloudmessage').hide();

        }
    });
}

if( config.hasCloudCredentials ){
    $('#cloudmessage').show();
    getCloudfiles();
}else{
    $('#cloudmessage').hide();
    $('#cloudnotoken').show();
}


$('#cloudfiles').on('change', function () {
    if($(this).val() == ''){
        return false;
    }

    $('#cloudmessage').show();
    $('#cloudmessage p').html("Das Bild wird geladen...");
    $.ajax({
        type: "POST",
        url: '../nextcloudget.php',
        data: {
            mode: 'file',
            file: $(this).val(),
            user: config.user,
            accesstoken: config.accesstoken,
        },
        success: function (data, textStatus, jqXHR) {
            $('#cloudmessage').hide();

            let obj = JSON.parse( data );
            let json = JSON.parse( obj.data );

            if( json.addpicfile1 != '') json.addpicfile1 = '../' + obj.dir + '/' + json.addpicfile1;
            if( json.addpicfile2 != '')json.addpicfile2 = '../' + obj.dir + '/' + json.addpicfile2;
            uploadFileByUrl( obj.dir + '/' + json.savedBackground, function (){
                loadFormData(  json );
            });

        }
    });
});

$('#cloudtokensave').click(function(){
    let token = $('#cloudtoken').val();

    $('#cloudmessage').show();
    $('#cloudmessage p').html('Speichere Token ...');
    $('#cloudnotoken').hide();


    $.post( "../save.php", { user: config.user,action: 'saveCloudToken',data: token, accesstoken: config.accesstoken })
        .done(function( data ) {

            $('#load').removeClass('d-none');
            $('#delete').removeClass('d-none');
            $('.saving-response').html("Gespeichert.").delay(2000).fadeOut();

            $('#cloudmessage').hide();

            $('#cloudhastoken').show();
        });


});

$('.cloudtokendelete').click(function(){

    if( !confirm("Wirklich die Verbindung zur Cloud löschen?") ){
        return false;
    }

    $.post( "../save.php", { user: config.user,action: 'deleteCloudToken', accesstoken: config.accesstoken })
        .done(function( data ) {
            $('#load').removeClass('d-none');
            $('#delete').removeClass('d-none');
            $('.saving-response').html("Gespeichert.").delay(2000).fadeOut();
        });

    $('#cloudnotoken').hide();
    $('#cloudhastoken').show();
});
