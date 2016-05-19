<?php 
/*
* Template Name: Zloc
*/
get_header();?>



    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?sensor=false">
    </script>
    <script type="text/javascript">
      var lat ;
      var long;
      var rs =[];
        var map = null;
            function showlocation() {
               // One-shot position request.
                 navigator.geolocation.getCurrentPosition(callback, errorHandler);
            }

//..
 
function errorHandler(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.");
      break;
    }
  }
         
      function callback(position) {
         
        lat = position.coords.latitude;
        lon = position.coords.longitude;
        rs=[lat,long];
        console.log(rs);
         
             document.getElementById('latitude').innerHTML = lat;
         document.getElementById('longitude').innerHTML = lon;
             
        var latLong = new google.maps.LatLng(lat, lon);
         
                var marker = new google.maps.Marker({
                    position: latLong
                });      
                 
                marker.setMap(map);
        map.setZoom(8);
        map.setCenter(marker.getPosition());
      }
       
      google.maps.event.addDomListener(window, 'load', initMap);
      function initMap() {
        var mapOptions = {
          center: new google.maps.LatLng(0, 0),
          zoom: 1,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), 
                                          mapOptions);
       
      }
    </script>
  </head>
  <body>
    <center>
        <input type="button" value="Show my location on Map"
                onclick="javascript:showlocation()" />   <br/>
    </center>
                 
        Latitude: <span id="latitude"></span>       <br/>
        Longitude: <span id="longitude"></span>
    <br/><br/>
    <div id="map-canvas"/>
  <?php get_footer();?>


  

