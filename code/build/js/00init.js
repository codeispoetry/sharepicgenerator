const draw = SVG().addTo('#canvas');
var info = { foo: null};

const bgpic = {
    width: 800,
    height: 450,
    originalWidth: 1920,
    originalHeight: 1080,
    filename: 'assets/bg_small.jpg'
};

const secondaryfont = {
    family: 'ArvoGruen',
    size: 15,
    anchor: 'left',
    weight: 700
};

$(document).ready(function () {
    afterUpload(bgpic);
    $('#text').val("[Leben]\nlassen");

    /*
    if( config["landesverband"] == 3) {
        $("#logoselect option[value='logo-berlin-weiss']").prop('selected', true);
        window.setTimeout(function () {
            $("#logoselect").change();
        }, 1000);
    }
    */


    if (/Edge/.test(navigator.userAgent)) {
        alert('Falls der Sharepicgenerator hier nicht funktioniert, probiere bitte einen anderen Browser, z.B. Firefox.');
    }
});

function message( text = false ){
    if( !text ){
        $('#message').hide();
        return;
    }
    $('#message').show().html( text );
}
