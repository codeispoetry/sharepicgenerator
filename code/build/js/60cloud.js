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
        }
    });
}
getCloudfiles();


$('#cloudfiles').on('change', function () {
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
            console.log( data );
            let obj = JSON.parse(data);

            console.log(obj)

        }
    });
});