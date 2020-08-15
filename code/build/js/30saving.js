function loadFormData( formdata ){

    // set the draw size manually, because it recalculates boundaries, etc.
    $('#width').val( formdata[ "width" ]);
    $('#height').val( formdata[ "height" ]);
    setDrawsize();

    for(var elem in formdata) {
        $('#' + elem).val( formdata[ elem ]);
    }

    let checkboxes = ["textsamesize","greenbehindtext","graybehindtext","addpicrounded1","addpicrounded2"];
    checkboxes.forEach( function(elem){
        if( formdata[ elem ] === "on" ){
            $("#" + elem).prop('checked', true);
            $('#' + elem).bootstrapToggle("on");
        }
    });

    window.setTimeout(function () {
        text.draw();
        logo.load();
        //background.draw();
        copyright.draw();
        pin.draw();
        icon.load();
        //addPic1.draw();
        //addPic2.draw();
        showLayout();
    }, 100);


    window.setTimeout(function () {
        copyright.draw(); // unknow, why this has to be performed later
        pin.draw();
    }, 500);


}

function savework(){
    let data = $('#pic').serialize();

    $.ajax({
        type: "POST",
        url: '/savework.php',
        data: {data: data},
        success: function (data, textStatus, jqXHR) {
            let obj = JSON.parse(data);
            let downloadname = getDownloadName();
            window.location.href = '/downloadwork.php?basename=' + obj.basename +  '&downloadname=' + downloadname;
        }
    });
}
