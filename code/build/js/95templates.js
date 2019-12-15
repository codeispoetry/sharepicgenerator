const persistent = {

    save() {

        let data = $('#pic').serializeArray();
        let json = {};

        $.each(data, function (key, item) {
            json[item.name] = item.value;
        });

        if (json.width != info.originalWidth || json.height != info.originalHeight) {
            alert("Speichern geht nur mit der Originalgröße des Bildes. Bitte setze es zurück.");
            return false;
        }

        //json['persistentname'] = 'must be sanitzed later';

        $.post("savetemplate.php", {data: JSON.stringify(json)})
            .done(function (data) {
                console.log(data);
                let obj = JSON.parse(data);

                //location.reload();

                if (!obj.success) {
                    console.log("Could not save data");
                }
            });
    },

    build(json) {

        $.getJSON(json, function (data) {

            uploadImageByUrl(data.backgroundURL, function () {

                $.each(data, function (key, value) {
                    $('#' + key).val(value);
                });

                pin.draw();
                text.draw();
            });

        });
    }
};


$('.persistentpic').click(function () {
    persistent.build($(this).data('pic'));
});


$('.persistentsave').click(persistent.save);



