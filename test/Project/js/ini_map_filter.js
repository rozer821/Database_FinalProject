
      var map;
      var default_point = {lat:40.694485, lng:-73.986640}
      var markers = [];
      var default_markers = [];
      var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
      var image2="js/pin_small_2.png";
      var test1=1;
      var lat ;
      var lng ;
           


//Choose the label on the marker
      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };
      

// Adds a marker to the map and push to the array.
      function addMarker(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
        setMapOnAll(null);
        marker.setMap(map);
        markers.push(marker);
      }

      function addMarkerone(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
      }


// Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }


// Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }


// Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }


// Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }


//initial the map
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: default_point,
          zoom: 15
        });


        //click listener 
        google.maps.event.addListener(map, 'click', function(event) {
           lat = event.latLng.lat();
           lng = event.latLng.lng();
           document.getElementById("latitude").value=lat;
           document.getElementById("longitude").value=lng;
           addMarker(event.latLng);
      });


        //make infoWindow for every marker and show the detail of marker
      var InfoWindow = new google.maps.InfoWindow;
      
      //set resource.

      downloadUrl('js/base.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var nid = markerElem.getAttribute('nid');
              var uname = markerElem.getAttribute('uname');
              var content = markerElem.getAttribute('ncontent');
              var type = markerElem.getAttribute('type');
              var point1 = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('nlatitude')),
                  parseFloat(markerElem.getAttribute('nlongitude')));
                  var point2 = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('latitude_action')),
                    parseFloat(markerElem.getAttribute('longitude_action')));
                var infowincontent = document.createElement('div');
                var strong = document.createElement('strong');
                strong.textContent = uname;
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));
  
                var text = document.createElement('text');
                text.textContent = content;
                infowincontent.appendChild(text);
                var icon = customLabel[type] || {};
                var marker = new google.maps.Marker({
                  map: map,
                  position: point1,
                  icon: image
                });
                var marker_action = new google.maps.Marker({
                  map: map,
                  position: point2,
                  icon: image2
  
                });
              default_markers.push(marker);
              marker.addListener('click', function() {
                InfoWindow.setContent(infowincontent);
                InfoWindow.open(map, marker);
              });
              
            });
          });
      }


      	//connect to conn.php and request dataset
		function downloadUrl(url, callback) {
		        var request = window.ActiveXObject ?
		            new ActiveXObject('Microsoft.XMLHTTP') :
		            new XMLHttpRequest;
		        request.onreadystatechange = function() {
		          if (request.readyState == 4) {
		            request.onreadystatechange = doNothing;
		            callback(request, request.status);
		          }
		        };
		        request.open('GET', url, true);
		        request.send(null);
		      }
		

    function doNothing() {}
