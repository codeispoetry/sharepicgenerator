const logo = {
        isLoaded: false,
        config: {
            "vintage": {
                file: "../vintage/vintage-logo.svg",
                widthFraction: 0.13,
                position: 'topright'
            }
        },

        load(whichLogo = "vintage") {

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
                    x = draw.width() - width - 15;
                    y = 15;
            }


            logo.svg.move(x, y);

        }


    }
;
logo.load();

