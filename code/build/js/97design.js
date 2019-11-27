const design = {

    use( whichDesign = '' ) {
        design.hideAllElements();
        switch( whichDesign ){
            case 'bigright':
                bigright.svg.show(); 
                bigright.fond.show();
                bigright.draw();
                break;
            case 'standard':
            case 'textbackground':
                text.svg.show();
                text.draw();
                logo.svg.show();
                pin.svg.show();
        }
        background.uncoveredAreaWarning();
    },

   hideAllElements(){
       text.svg.hide();
       logo.svg.hide();
       pin.svg.hide();
       bigright.svg.hide();
       bigright.fond.hide();
   }
    
};

design.use($('#design').val());

$('#design').on('change', function () {
    design.use( this.value );
});

