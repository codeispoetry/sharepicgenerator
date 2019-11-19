$('#textfieldresize').bind('input propertychange', function() {
    let val = parseInt( $(this).val() );
    textfield.size( val );
    info.size = val;
})