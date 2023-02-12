const undo = {
    states: new Array(),
  
    save () {

        const data = Object.fromEntries(new FormData(document.getElementById('pic')));

        undo.states.unshift(data);

        if(undo.states.length > 10) {
            undo.states.pop();
        }
    },

    draw() {
        if(undo.states.length == 0) {
            alert("Rückgängig nicht möglich.");
            return;
        }
        fillForm(undo.states.shift());
        applyFormWithoutBackground();
    },
}

function KeyPress(e) {
    if (e.keyCode == 90 && e.ctrlKey) {
        undo.draw();
        e.preventDefault();
        e.stopPropagation();
    }
   
}

document.onkeydown = KeyPress;
