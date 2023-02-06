function dropHandler(ev) {
    ev.preventDefault();
  
    if (ev.dataTransfer.items) {
      [...ev.dataTransfer.items].forEach((item, i) => {
        if (item.kind === 'file') {
          const file = item.getAsFile();
          changeFile(file, 'uploadfile');

        }
      });
    } else {
      [...ev.dataTransfer.files].forEach((file, i) => {
        changeFile(file, 'uploadfile');
      });
    }
  }

  function dragOverHandler(ev) {
    ev.preventDefault();
  }

