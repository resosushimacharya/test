<div id="<?php echo the_ID();  ?>">
<div id="gmap" style="height: 325px; width:100%;"></div>
</div>



<?php 
$locState = array();
$args= array('post_type'=>'wpsl_stores');
$loop = new WP_Query($args);
while($loop->have_posts()):
   $loop->the_post();
  // the_title();
   $mpos = get_post_meta($post->ID);
   //do_action('pr',$mpos);
   
    
    endwhile;
    wp_reset_query();
    $query = new WP_Query( array( 'meta_key' => 'wpsl_state', 'meta_value' => 'NSW' ,'post_type'=>'wpsl_stores') );

   $countNSW = $query->found_posts;
   $locState[] = array('NSW, AUSTRALIA',$countNSW);
   wp_reset_query();
   $query = new WP_Query( array( 'meta_key' => 'wpsl_state', 'meta_value' => 'SA' ,'post_type'=>'wpsl_stores') );

   $countSA = $query->found_posts;
    $locState[] = array('SA, AUSTRALIA',$countSA);
   wp_reset_query();
   $query = new WP_Query( array( 'meta_key' => 'wpsl_state', 'meta_value' => 'TAS' ,'post_type'=>'wpsl_stores') );

   $countTAS = $query->found_posts;
    $locState[] = array('TAS, AUSTRALIA',$countTAS);
   wp_reset_query();
   $query = new WP_Query( array( 'meta_key' => 'wpsl_state', 'meta_value' => 'VIC' ,'post_type'=>'wpsl_stores') );

   $countVIC = $query->found_posts;
    $locState[] = array('VIC, AUSTRALIA',$countVIC);

   wp_reset_query();
   $query = new WP_Query( array( 'meta_key' => 'wpsl_state', 'meta_value' => 'QLD' ,'post_type'=>'wpsl_stores') );

   $countQLD = $query->found_posts;
    $locState[] = array('QLD, AUSTRALIA',$countQLD);
   wp_reset_query();
    $query = new WP_Query( array( 'meta_key' => 'wpsl_state', 'meta_value' => 'WA' ,'post_type'=>'wpsl_stores') );

   $countWA = $query->found_posts;
    $locState[] = array('WA, AUSTRALIA',$countWA);

   // echo $countWA;
   wp_reset_query();
  // do_action('pr',$locState);





?>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js">
</script> 

<script>
 stoLLPTL=[];
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;  
    myx = [];
    myx = [-33.811721, 151.192396];
    setTimeout(function(){ loadmap(); }, 2000);
   sll.push(myx);
   //alert(sll);
    
}
 var locations = [
<?php

 foreach ($locState as $lst): ?>
                ['<?php echo $lst[1]; ?>', "<?php echo $lst[0]; ?>"],
    <?php endforeach; ?>

 ];
  //alert(locations.length);
    console.log(locations);
    var rs = [];
    var myrs= [];
    var geocoder;
    var map;
    var bounds = new google.maps.LatLngBounds();
    //alert(bounds);
    function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}
    function initialize() {

       

        map = new google.maps.Map(document.getElementById("gmap"), {

            center: new google.maps.LatLng(42, -97),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,

    navigationControl: false,
    mapTypeControl: false,
    scaleControl: false,
    draggable: false,
    disableDefaultUI: true,
            zoom: 3,
          styles: [
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e9e9e9"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 29
                        },
                        {
                            "weight": 0.2
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 18
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dedede"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "saturation": 36
                        },
                        {
                            "color": "#333333"
                        },
                        {
                            "lightness": 40
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f2f2f2"
                        },
                        {
                            "lightness": 19
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 17
                        },
                        {
                            "weight": 1.2
                        }
                    ]
                }
            ]


        });
           
        // This is needed to set the zoom after fitbounds, 
        google.maps.event.addListener(map, 'zoom_changed', function() {



            zoomChangeBoundsListener = 
                google.maps.event.addListener(map, 'bounds_changed', function(event) {
                   /*/ if (this.getZoom() > 8 && this.initialZoom === true) {
                        // Change max/min zoom here
                        this.setZoom(10);
                        this.initialZoom = false;
                    }*/
                    this.setZoom(4);
                google.maps.event.removeListener(zoomChangeBoundsListener);
            });
        });
        map.initialZoom = true;
        map.fitBounds(bounds);
           
        geocoder = new google.maps.Geocoder();

        for (i = 0; i < locations.length; i++) {


            geocodeAddress(locations, i);
           // alert()
           
        }


    }
    google.maps.event.addDomListener(window, "load", initialize);





    function geocodeAddress(locations, i) {
        var title = locations[i][0];
        var address = locations[i][1];
        geocoder.geocode({
            'address': locations[i][1]
        },
                function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                       
                        //alert(results[0].geometry.location);
                          //(results[0].geometry.location.latitude);
                          console.log(results[0].geometry.location);
                          var res=results[0].geometry.location;
                         dis = getDistanceFromLatLonInKm(res.lat(), res.lng(), -33.837864, 151.02846769999996)
                             //if()

                           // alert(dis+'km');
                          //alert(res.lng());
                             
                            // rs.push([res.lat(),res.lng()]);
                            // alert(rs);
                           
                            console.log(rs);
                                var state = address.split(',');
                                var asl=state[0];
                               
                        var marker_img = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                        var marker = new google.maps.Marker({
                            icon: marker_img,
                            map: map,
                            position: results[0].geometry.location,
                            title: title,
                            animation: google.maps.Animation.DROP,
                            address: address,
                            
                        })
                        infoWindow(marker, map, title, address,asl);

                        bounds.extend(marker.getPosition());
                        map.fitBounds(bounds);
                    } else {
                        alert("geocode of " + address + " failed:" + status);
                    }
                  
               

              /*for(var h=0;h<rs.)
              dis = getDistanceFromLatLonInKm(rs, sll[4][1], sll[i][0], sll[i][1])
        if(dis<1000)
        {    //alert(dis);
            alert(perm[i]);
            prakashArray.push({'lat': sll[i][0], 'long' : sll[i][1],'myloc':city[i],'stoperm':perm[i]});
            

        }*/

               });
     }
    
       


    function infoWindow(marker, map, title,address,asl) {
        if (typeof (window.google) !== 'undefined' && google.maps) {
            
                var html = "<div class='map_info' style='height:40px;width:50px;z-index:-10><div class='contents'><h5 style='color:red;''>" + asl +'</h5>'+ "<h6>" + title  + "Stores</h6></div></div>";

                iw = new google.maps.InfoWindow({
                    content: html,
                    maxWidth: 350,
                    pixelOffset: new google.maps.Size(-20,40)
                });
                iw.open(map, marker);

           
        }



        
    }


   /* function createMarker(results) {
        var marker_img = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
        var marker = new google.maps.Marker({
            icon: marker_img,
            map: map,
            position: results[0].geometry.location,
            title: title,
            animation: google.maps.Animation.DROP,
            address: address,
            url: url
        })
        bounds.extend(marker.getPosition());
        map.fitBounds(bounds);
        infoWindow(marker, map, title, address, url);
        return marker;
    }*/



</script> 