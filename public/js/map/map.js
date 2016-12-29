class Map {
  constructor() {}

  load(geographic) {
    this.createHiddenData();

    let lat = 13.297587657705135;
    let lng = 100.94727516174316;

    let setMarker = false;

    if (typeof geographic != 'undefined') {
      let _geographic = JSON.parse(geographic);

      if ((typeof _geographic.lat != 'undefined') && (typeof _geographic.lng != 'undefined')) {
        lat = _geographic.lat;
        lng = _geographic.lng;

        $("#lat").val(lat);
        $("#lng").val(lng);

        setMarker = true;
      }

    }

    this.initialize(new google.maps.LatLng(lat,lng),setMarker);

  }

  initialize(latlng,setMarker) {
    // let latlng = new google.maps.LatLng(Map.lat, Map.lng);
    let options = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    let map = new google.maps.Map(document.getElementById("map"), options);

    let marker = new google.maps.Marker();
    if(setMarker) {
      marker = new google.maps.Marker({
              position: latlng,
              map: map
            });
    }

    // Create the search box and link it to the UI element.
    let input = document.getElementById('pac-input');
    let searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    let geocoder = new google.maps.Geocoder();

    google.maps.event.addListener(map, 'click', function(event) {

      marker.setMap(null);

      marker = new google.maps.Marker({
        map: map,
        position: {lat: event.latLng.lat(), lng: event.latLng.lng()}
      });

      $("#lat").val(event.latLng.lat());
      $("#lng").val(event.latLng.lng());

      geocoder.geocode({
        'latLng': event.latLng
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            $("#address").text(results[0].formatted_address);
          }
        }
      });

    });

    searchBox.addListener('places_changed', function() {
      let places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      marker.setMap(null);

      // For each place, get the icon, name and location.
      let bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }

        $("#lat").val(place.geometry.location.lat());
        $("#lng").val(place.geometry.location.lng());

        geocoder.geocode({
          'latLng': place.geometry.location
        }, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              $("#address").text(results[0].formatted_address);
            }
          }
        });

        marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
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

  createHiddenData() {
    let lat = document.createElement('input');
    lat.setAttribute('type','hidden');
    lat.setAttribute('name','Address[lat]');
    lat.setAttribute('id','lat');

    let lng = document.createElement('input');
    lng.setAttribute('type','hidden');
    lng.setAttribute('name','Address[lng]');
    lng.setAttribute('id','lng');

    $('form').append(lat);
    $('form').append(lng);
  }

}




// var Map = {}

// Map.load = function(geographic) {
//   Map.createHiddenData();

//   var lat = 13.297587657705135;
//   var lng = 100.94727516174316;

//   var setMarker = false;

//   if (typeof geographic != 'undefined') {
//     var _geographic = JSON.parse(geographic);

//     if ((typeof _geographic.lat != 'undefined') && (typeof _geographic.lng != 'undefined')) {
//       lat = _geographic.lat;
//       lng = _geographic.lng;

//       $("#lat").val(lat);
//       $("#lng").val(lng);

//       setMarker = true;
//     }

//   }

//   Map.initialize(new google.maps.LatLng(lat,lng),setMarker);

// }

// Map.initialize = function(latlng,setMarker) {
//   // var latlng = new google.maps.LatLng(Map.lat, Map.lng);
//   var options = {
//       zoom: 13,
//       center: latlng,
//       mapTypeId: google.maps.MapTypeId.ROADMAP
//   }
//   var map = new google.maps.Map(document.getElementById("map"), options);

//   var marker = new google.maps.Marker();
//   if(setMarker) {
//     marker = new google.maps.Marker({
//             position: latlng,
//             map: map
//           });
//   }

//   // Create the search box and link it to the UI element.
//   var input = document.getElementById('pac-input');
//   var searchBox = new google.maps.places.SearchBox(input);
//   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

//   // Bias the SearchBox results towards current map's viewport.
//   map.addListener('bounds_changed', function() {
//     searchBox.setBounds(map.getBounds());
//   });

//   var geocoder = new google.maps.Geocoder();

//   google.maps.event.addListener(map, 'click', function(event) {

//     marker.setMap(null);

//     marker = new google.maps.Marker({
//       map: map,
//       position: {lat: event.latLng.lat(), lng: event.latLng.lng()}
//     });

//     $("#lat").val(event.latLng.lat());
//     $("#lng").val(event.latLng.lng());

//     geocoder.geocode({
//       'latLng': event.latLng
//     }, function(results, status) {
//       if (status == google.maps.GeocoderStatus.OK) {
//         if (results[0]) {
//           $("#address").text(results[0].formatted_address);
//         }
//       }
//     });

//   });

//   searchBox.addListener('places_changed', function() {
//     var places = searchBox.getPlaces();

//     if (places.length == 0) {
//       return;
//     }

//     marker.setMap(null);

//     // For each place, get the icon, name and location.
//     var bounds = new google.maps.LatLngBounds();
//     places.forEach(function(place) {
//       if (!place.geometry) {
//         console.log("Returned place contains no geometry");
//         return;
//       }

//       $("#lat").val(place.geometry.location.lat());
//       $("#lng").val(place.geometry.location.lng());

//       geocoder.geocode({
//         'latLng': place.geometry.location
//       }, function(results, status) {
//         if (status == google.maps.GeocoderStatus.OK) {
//           if (results[0]) {
//             $("#address").text(results[0].formatted_address);
//           }
//         }
//       });

//       marker = new google.maps.Marker({
//         map: map,
//         position: place.geometry.location
//       });

//       if (place.geometry.viewport) {
//         // Only geocodes have viewport.
//         bounds.union(place.geometry.viewport);
//       } else {
//         bounds.extend(place.geometry.location);
//       }
//     });
//     map.fitBounds(bounds);
//   });

// }

// // function initAutocomplete() {

// //   var latlng = {lat: Map.lat, lng: Map.lng};

// //   var map = new google.maps.Map(document.getElementById('map'), {
// //     center: latlng,
// //     zoom: 13,
// //     mapTypeId: 'roadmap'
// //   });

// //   // var marker = new google.maps.Marker();

// //   // var marker = new google.maps.Marker({
// //   //   position: latlng,
// //   //   map: map,
// //   // });

// //   var geocoder = new google.maps.Geocoder();

// //   // geocoder.geocode({
// //   //   'latLng': latlng
// //   // }, function(results, status) {
// //   //   if (status == google.maps.GeocoderStatus.OK) {
// //   //     if (results[0]) {
// //   //       $("#address").text(results[0].formatted_address);
// //   //     }
// //   //   }
// //   // });

// //   // Create the search box and link it to the UI element.
// //   var input = document.getElementById('pac-input');
// //   var searchBox = new google.maps.places.SearchBox(input);
// //   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

// //   // Bias the SearchBox results towards current map's viewport.
// //   map.addListener('bounds_changed', function() {
// //     searchBox.setBounds(map.getBounds());
// //   });

// //   google.maps.event.addListener(map, 'click', function(event) {

// //     marker.setMap(null);

// //     marker = new google.maps.Marker({
// //       map: map,
// //       position: {lat: event.latLng.lat(), lng: event.latLng.lng()}
// //     });

// //     $("#lat").val(event.latLng.lat());
// //     $("#lng").val(event.latLng.lng());

// //     geocoder.geocode({
// //       'latLng': event.latLng
// //     }, function(results, status) {
// //       if (status == google.maps.GeocoderStatus.OK) {
// //         if (results[0]) {
// //           $("#address").text(results[0].formatted_address);
// //         }
// //       }
// //     });

// //   });

// //   searchBox.addListener('places_changed', function() {
// //     var places = searchBox.getPlaces();

// //     if (places.length == 0) {
// //       return;
// //     }

// //     marker.setMap(null);

// //     // Clear out the old markers.
// //     // markers.forEach(function(marker) {
// //     //   marker.setMap(null);
// //     // });
// //     // markers = [];

// //     // For each place, get the icon, name and location.
// //     var bounds = new google.maps.LatLngBounds();
// //     places.forEach(function(place) {
// //       if (!place.geometry) {
// //         console.log("Returned place contains no geometry");
// //         return;
// //       }
// //       // var icon = {
// //       //   url: place.icon,
// //       //   size: new google.maps.Size(71, 71),
// //       //   origin: new google.maps.Point(0, 0),
// //       //   anchor: new google.maps.Point(17, 34),
// //       //   scaledSize: new google.maps.Size(25, 25)
// //       // };

// //       // // Create a marker for each place.
// //       // markers.push(new google.maps.Marker({
// //       //   map: map,
// //       //   icon: icon,
// //       //   title: place.name,
// //       //   position: place.geometry.location
// //       // }));

// //       $("#lat").val(place.geometry.location.lat());
// //       $("#lng").val(place.geometry.location.lng());

// //       geocoder.geocode({
// //         'latLng': place.geometry.location
// //       }, function(results, status) {
// //         if (status == google.maps.GeocoderStatus.OK) {
// //           if (results[0]) {
// //             $("#address").text(results[0].formatted_address);
// //           }
// //         }
// //       });

// //       marker = new google.maps.Marker({
// //         map: map,
// //         position: place.geometry.location
// //       });

// //       if (place.geometry.viewport) {
// //         // Only geocodes have viewport.
// //         bounds.union(place.geometry.viewport);
// //       } else {
// //         bounds.extend(place.geometry.location);
// //       }
// //     });
// //     map.fitBounds(bounds);
// //   });

//   // var infoWindow = new google.maps.InfoWindow({map: map});

//   // if (navigator.geolocation) {
//   //   navigator.geolocation.getCurrentPosition(function(position) {
//   //     var pos = {
//   //       lat: position.coords.latitude,
//   //       lng: position.coords.longitude
//   //     };

//   //     infoWindow.setPosition(pos);
//   //     infoWindow.setContent('Location found.');
//   //     map.setCenter(pos);
//   //   }, function() {
//   //     handleLocationError(true, infoWindow, map.getCenter());
//   //   });
//   // } else {
//   //   // Browser doesn't support Geolocation
//   //   handleLocationError(false, infoWindow, map.getCenter());
//   // }

// // }

// // function handleLocationError(browserHasGeolocation, infoWindow, pos) {
// //         infoWindow.setPosition(pos);
// //         infoWindow.setContent(browserHasGeolocation ?
// //                               'Error: The Geolocation service failed.' :
// //                               'Error: Your browser doesn\'t support geolocation.');
// //       }

// Map.createHiddenData = function() {

//   let lat = document.createElement('input');
//   lat.setAttribute('type','hidden');
//   lat.setAttribute('name','Address[lat]');
//   lat.setAttribute('id','lat');

//   let lng = document.createElement('input');
//   lng.setAttribute('type','hidden');
//   lng.setAttribute('name','Address[lng]');
//   lng.setAttribute('id','lng');

//   $('form').append(lat);
//   $('form').append(lng);
  
// }