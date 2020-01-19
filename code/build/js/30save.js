function loadSvg(){

    let ajax = new XMLHttpRequest()
    
    ajax.open('GET', 'tmp/vorlage.svg', true)
    ajax.send()

    ajax.onload = function(e) {
        console.log(e,ajax)
        draw.svg(ajax.responseText)
    }
}