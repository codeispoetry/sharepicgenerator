$('#templateopener').click(function () {
    $('head meta[name="viewport"]').attr('content','width=device-width, initial-scale=1');

    $('#templates').addClass("active");
});


$('.templatepic').click(function(){
    let template = $(this);
    let attribution = $(this).data("attribution");
    uploadImageByUrl( $(this).attr("src"), function(){
        setCopyright( attribution, '');

        let str = template.data('text').replace(/@/g,'!').replace(/§/g,"\n");
        $('#text').val( str );

        $('#textX').val(template.data("x"));
        $('#textY').val(template.data("y"));
        $('#textsize').val(template.data("size"));
        //$('#backgroundsize').val(template.data("backgroundsize"));
       // background.resize();

    });

});