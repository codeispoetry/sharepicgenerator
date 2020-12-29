function setUserPrefs() {
  $.ajax({
    type: 'POST',
    url: '/actions/user.php',
    data: {
      prefs: JSON.stringify(config.user.prefs),
      user: config.user,
      csrf: config.csrf,
    },
    success(response) {
    },
    error(response) {
      console.log(response);
    },
  });
}
