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
        console.log(data)
    },
  });
}

$('.save').click(function() {
  save();
});
