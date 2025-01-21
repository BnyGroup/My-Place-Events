function initAutocomplete() {

        var inputs = document.getElementById('header-location');
        var autocompletes = new google.maps.places.Autocomplete(inputs);
        autocompletes.addListener('place_changed', function () {
            var placess = autocompletes.getPlace();
            $('#location_selected').val(placess.address_components[0].long_name);            
        });


        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('create_events');
        var searchBox = new google.maps.places.SearchBox(input);
        // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);
          google.maps.event.addListener(autocomplete, 'place_changed', function () {
              var place = autocomplete.getPlace();
              document.getElementById('latbox').value = place.geometry.location.lat();
              document.getElementById('lngbox').value = place.geometry.location.lng();
              document.getElementById('city').value   = place.name;
          });


        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }

            // Create a marker for each place.
            var marker = new google.maps.Marker({
                position: place.geometry.location,
                map: map,
                draggable:true,
                title:"Drag me!"
               });

          marker.addListener('click', toggleBounce);
             function toggleBounce() {
          if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
          } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
          }
        }

       google.maps.event.addListener(marker, 'dragend', function (event) {
          document.getElementById("latbox").value = event.latLng.lat();
          document.getElementById("lngbox").value = event.latLng.lng();
      });

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      map.fitBounds(bounds);
  });

}