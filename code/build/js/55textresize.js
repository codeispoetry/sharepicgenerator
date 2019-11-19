$('#textfieldresize').bind('input propertychange', function() {
    let val = parseInt( $('#textfieldresize').val() );
    textfield.size( val );
    info.size = val;
})