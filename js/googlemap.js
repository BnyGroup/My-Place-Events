/* ========================================= */
/* GOOGLE MAP SCRIPT */
/* ========================================= */
function Autocompleteinit() {
  var input = document.getElementById('header-location');
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.addListener('place_changed', function () {
      var place = autocomplete.getPlace();
      $('#location_selected').val(place.address_components[0].long_name);            
  });
}
