/* eslint-disable no-unused-vars */
function checkForOtherTenant() {
  if (!$('#text').val().toLowerCase().includes('frankfurt')) {
    return false;
  }

  $('#other-tenant-url').attr('href', '/frankfurt');
  $('#other-tenant-name').html('Frankfurt');
}
