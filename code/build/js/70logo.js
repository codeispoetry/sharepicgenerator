const logo = {
        isLoaded: false,
        config: {
            "sonnenblume": {
                file: "assets/logos/sonnenblume.svg",
                widthFraction: 0.1,
                position: 'topright'
            },
            "sonnenblume-weiss": {
                file: "assets/logos/sonnenblume-weiss.svg",
                widthFraction: 0.1,
                position: 'topright'
            },
            "logo-weiss": {
                file: "assets/logos/logo-weiss.svg",
                widthFraction: 0.2,
                position: 'topright'
            },
            "logo-gruen": {
                file: "assets/logos/logo-gruen.svg",
                widthFraction: 0.20,
                position: 'topright'
            },
            "sonnenblume-big": {
                file: "assets/logos/sonnenblume.svg",
                widthFraction: 0.5,
                position: 'bottomleftOutside',
            }
        },

        load(whichLogo = "sonnenblume") {

            if (this.svg) this.svg.remove();
            logo.isLoaded = false;

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

