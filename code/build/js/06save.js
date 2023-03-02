function save() {
  $.ajax({
    type: 'POST',
    url: '/actions/save.php',
    data: {
      sharepic: $('#pic').serialize(),
      config: JSON.stringify(config),
      log: JSON.stringify(log),
    },
    success(data) {
        const obj = JSON.parse(data);
    },
  });
}

function deleteSharepic() {
  $.ajax({
    type: 'POST',
    url: '/actions/delete.php',
    data: {
      config: JSON.stringify(config),
    },
    success(data) {
        const obj = JSON.parse(data);
        console.log(obj)
    },
  });
}


$('.save-sharepic').click(function() {
  save();
  alert("Dein Sharepic wurde online gespeichert. Du kannst es jederzeit wieder laden und löschen.");
});

$('.open-sharepic').click(function() {
  open();
});

$('.delete-sharepic').click(function() {
  deleteSharepic();
  alert("Dein Sharepic wurde gelöscht.");
  window.location.reload();
});
