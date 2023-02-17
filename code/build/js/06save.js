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
});

$('.open-sharepic').click(function() {
  open();
});

$('.delete-sharepic').click(function() {
  deleteSharepic();
  window.location.reload();
});
