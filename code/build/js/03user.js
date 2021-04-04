function setUserPrefs() {
  $.ajax({
    type: 'POST',
    url: '/actions/user.php',
    data: {
      prefs: JSON.stringify(config.user.prefs),
      csrf: config.csrf,
    },
    success(response) {
    },
    error(response) {
      console.log(response);
    },
  });
}

function isGuest(){
  return config.username == 'guest';
}
