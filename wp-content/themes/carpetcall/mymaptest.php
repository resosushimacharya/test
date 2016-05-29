<?php /*
* Template Name: searchmap
*/

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Place Autocomplete</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

     
    </style>

  </head>
  <body>
    <input id="pac-input" class="controls" type="text"
        placeholder="Suburb or Subcode">
    
    

    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

  var stoLocation= [];
      function initMap() {
        var input = document.getElementById('pac-input');
       var options = { types: ['geocode'],componentRestrictions: {country: "AU"} };
        var types = document.getElementById('type');
      

        var autocomplete = new google.maps.places.Autocomplete(input,options);
      //  console.log(autocomplete);
      

        
        autocomplete.addListener('place_changed', function() {
         
          var place = autocomplete.getPlace();
           stoLocation.push(place);
          alert(place.geometry.location.lat());
          input.value="";

          console.log(place);
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          
          

         
        });

       
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"
        async defer></script>
  </body>
</html>