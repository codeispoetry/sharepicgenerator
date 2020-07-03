function getCloudfiles(){
    $.ajax({
        type: "POST",
        url: '../nextcloudget.php',
        data: {
            user: config.user,
            accesstoken: config.accesstoken,
        },
        success: function (data, textStatus, jqXHR) {
            console.log(data);
            let obj = JSON.parse(data);
            obj.data.forEach ( element => {
                console.log(element)
                $("#cloudfiles").append(new Option( basename(element), element ));
            });
        }
    });
}

getCloudfiles();