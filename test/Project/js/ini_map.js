var map;
      var default_point = {lat:40.694485, lng:-73.986640}
      var markers = [];
      var default_markers = [];
      var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
      var image2 = 'js/pin_small_2.png';
      var lat ;
      var lng ;
           


//Choose the label on the marker
      // var customLabel = {
      //   restaurant: {
      //     label: 'R'
      //   },
      //   bar: {
      //     label: 'B'
      //   }
      // };
      

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
           
           addMarker(event.latLng);
      });


        //make infoWindow for every marker and show the detail of marker
      var InfoWindow = new google.maps.InfoWindow;
      var InfoWindow_action = new google.maps.InfoWindow;
      //set resource.

      downloadUrl('js/base.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var nid = markerElem.getAttribute('nid');
              // var uid = markerElem.getAttribute('uid');
              var content = markerElem.getAttribute('ncontent');
              var uname = markerElem.getAttribute('uname');
              var point1 = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('nlatitude')),
                  parseFloat(markerElem.getAttribute('nlongitude')));
              var point2 = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('latitude_action')),
                  parseFloat(markerElem.getAttribute('longitude_action'))
                );
              var start_date = markerElem.getAttribute('note_start_date');
              var end_date = markerElem.getAttribute('note_end_date');
              var start_time = markerElem.getAttribute('note_start_time');
              var end_time = markerElem.getAttribute('note_end_time');
              var radius = markerElem.getAttribute('nradius');
              var limit_view = markerElem.getAttribute('limit_view');
              var repeat_type = markerElem.getAttribute('repeat_type');
              var repeat_date = markerElem.getAttribute('repeat_date');

              
              

              
              var ac_lon = markerElem.getAttribute('longitude_action');
              var ac_lat = markerElem.getAttribute('latitude_action');
              var infowincontent_action = document.createElement('div');
              var time = markerElem.getAttribute('current_time');
              var time_text = document.createElement('text');
              time_text.textContent = "time: " + time;
              var loc_text = document.createElement('text');
              loc_text.textContent = "location: " + ac_lat + "," + ac_lon;
              infowincontent_action.appendChild(time_text);
              infowincontent_action.appendChild(document.createElement('br'));
              infowincontent_action.appendChild(loc_text);
              
              

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              var text = document.createElement('text');
              var se_date = document.createElement('text');
              var se_time = document.createElement('text');
              var raidus_text = document.createElement('text');
              var limit_view_text = document.createElement('text');
              var repeat_type_text = document.createElement('text');
              var repeat_date_text = document.createElement('text');

              text.textContent = "content: " + content;
              strong.textContent = "uname: " + uname;
              se_date.textContent = "start_date: " + start_date + " end_date: " + end_date;
              se_time.textContent = "start_time: " + start_time + " end_time: " + end_time;
              raidus_text.textContent = "radius: " + radius;
              limit_view_text.textContent = "limit_view: " + limit_view;
              repeat_date_text.textContent = "repeat_date :" + repeat_date;
              repeat_type_text.textContent = "repeat_time :" + repeat_type;
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
              
              infowincontent.appendChild(text);
              infowincontent.appendChild(document.createElement('br'));

              infowincontent.appendChild(se_date);
              infowincontent.appendChild(document.createElement('br'));

              infowincontent.appendChild(se_time);
              infowincontent.appendChild(document.createElement('br'));

              infowincontent.appendChild(raidus_text);
              infowincontent.appendChild(document.createElement('br'));

              infowincontent.appendChild(limit_view_text);
              infowincontent.appendChild(document.createElement('br'));


              infowincontent.appendChild(repeat_date_text);
              infowincontent.appendChild(document.createElement('br'));
              
              infowincontent.appendChild(repeat_type_text);
              infowincontent.appendChild(document.createElement('br'));
              // var icon = customLabel[type] || {};
              



              var marker_action = new google.maps.Marker({
                map: map,
                position: point2,
                icon: image2
              });
              marker_action.addListener('click',function(){
                InfoWindow_action.setContent(infowincontent_action);
                InfoWindow_action.open(map,marker_action);

              });
              

              
                var marker = new google.maps.Marker({
                map: map,
                position: point1,
                icon: image
              });

              marker.addListener('click', function() {
                InfoWindow.setContent(infowincontent);
                InfoWindow.open(map, marker);
              });
              // default_markers.push(marker_action);
              default_markers.push(marker);
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