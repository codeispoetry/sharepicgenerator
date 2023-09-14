const undo = {
    states: new Array(),
  
    save () {
        return;
        const data = Object.fromEntries(new FormData(document.getElementById('pic')));

        undo.states.unshift(data);

        if(undo.states.length > 10) {
            undo.states.pop();
        }

        $('.undo').removeClass('disabled');
    },

    draw() {
        return;
        if(undo.states.length == 0) {
            alert("Rückgängig nicht möglich.");
            return;
        }
        fillForm(undo.states.shift());
        applyFormWithoutBackground();

        if(undo.states.length == 0) {
            $('.undo').addClass('disabled');
        }
    },
}

function KeyPress(e) {
    return;
    if (e.keyCode == 90 && e.ctrlKey) {
        undo.draw();
        e.preventDefault();
        e.stopPropagation();
    }
   
}

document.onkeydown = KeyPress;

$('.undo').click(() => {
    return;
    undo.draw();
});
