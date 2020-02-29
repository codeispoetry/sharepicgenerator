const logo = {
        isLoaded: false,
        config: {
            "sonnenblume": {
                file: "../assets/logos/sonnenblume.svg",
                widthFraction: 0.1,
                position: 'topright'
            },
            "sonnenblume-weiss": {
                file: "../assets/logos/sonnenblume-weiss.svg",
                widthFraction: 0.1,
                position: 'topright'
            },
            "frauenrechte": {
                file: "../assets/logos/frauenrechte.svg",
                widthFraction: 0.1,
                position: 'topright'
            },
            "regenbogen": {
                file: "../assets/logos/regenbogen.png",
                widthFraction: 0.1,
                position: 'topright'
            },
            "logo-weiss": {
                file: "../assets/logos/logo-weiss.svg",
                widthFraction: 0.2,
                position: 'topright'
            },
            "logo-gruen": {
                file: "../assets/logos/logo-gruen.svg",
                widthFraction: 0.20,
                position: 'topright'
            },
            "sonnenblume-big": {
                file: "../assets/logos/sonnenblume.svg",
                widthFraction: 0.5,
                position: 'bottomleftOutside',
            },
            "logo-berlin-weiss": {
                file: "../assets/logos/berlin-weiss.svg",
                widthFraction: 0.2,
                position: 'topright'
            },
            "logo-berlin-gruen": {
                file: "../assets/logos/berlin-gruen.svg",
                widthFraction: 0.2,
                position: 'topright'
            },
            "custom": {
                file: "../persistent/user/" + config.user + "/logo.png",
                widthFraction: 0.2,
                position: 'topright'
            }
        },

        load() {
            whichLogo = $('#logoselect').val();
            if (logo.svg) logo.svg.remove();
            logo.isLoaded = false;

            if( whichLogo == 'void'){
                return false;
            }

            this.logoinfo = this.config[whichLogo];

            this.svg = draw.image(this.logoinfo.file, function (event) {
                logo.isLoaded = true;
                logo.draw();
            });
        },

        draw() {
            if (!logo.isLoaded) return false;

            let width = Math.max(50, draw.width() * logo.logoinfo.widthFraction);
            logo.svg.size(width);
            let x, y;

            switch (logo.logoinfo.position) {
                case 'bottomleft':
                    x = 10;
                    y = draw.height() - logo.svg.height() - 10 - 20;
                    break;
                case 'bottomleftOutside':
                    x = -(width * 0.5) + 20;
                    y = -20 + draw.height() - logo.svg.height() * .5;
                    break;
                default:
                    x = draw.width() - width - 10;
                    y = 10;
            }

            logo.svg.move(x, y);

        }


    }
;
logo.load();

$('#logoselect').on('change', function () {
    if($(this).val() == "custom"){
        $('#uploadlogo').click();
        return;
    }

    if($(this).val() == "deletecustomlogo"){
        if( !confirm("Eigenes Logo wirklich dauerhaft löschen?")){
            return;
        }

        $("#logoselect").val($("#logoselect option:first").val());

        $.post( "../delete.php", { user: config.user,accesstoken: config.accesstoken })
        .done(function( data ) {

            let obj = JSON.parse(data);
            if(obj.error){
                return false;
            }

        });

        logo.load( );

        return;
    }

    logo.load( );
});

$('.uselogo').on('click', function () {
    $('#logoselect').val( $(this).data('logo'));
    logo.load();
});

