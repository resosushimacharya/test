
<div style="overflow:hidden;height:259px;width:90%;margin-left:5px;">
<div id="gmap" style="position:relative;height: 500px; width:100%;top:-120px"></div>
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
            zoom:20,

    //#c6d3ea
           
          styles: [
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#FFFFFF"
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
                            "color": "#c6d3ea"
                        }

                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#c6d3ea"
                        },
                        {
                            "lightness": 17
                        },
                         {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#c6d3ea"
                        },
                        {
                            "lightness": 29
                        },
                        {
                            "weight": 0.2
                        },
                         {
                            "visibility": "off"
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
                        },
                        {
                            "visibility": "off"
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
                        }, 
                        {
                            "visibility": "off"
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
                        , {
                            "visibility": "off"
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
                        },
                        {
                            "visibility": "off"
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
                        },
                        {
                            "visibility": "off"
                        }

                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            
                            "border" : "2px solid black"
                        },
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
                        },{
                            "visibility": "off"
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
                        },{
                            "visibility": "off"
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
                        }, 
                        {
                            
                            "visibility": "off"
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
                    this.setZoom(3);
                google.maps.event.removeListener(zoomChangeBoundsListener);
            });
        });
        map.initialZoom = true;
        map.fitBounds(bounds);
           
        geocoder = new google.maps.Geocoder();

        for (i = 0; i < locations.length; i++) {


            geocodeAddress(locations, i);
           // alert()
           var myoverlay = new google.maps.OverlayView();
  myoverlay.draw = function () {
    //this assigns an id to the markerlayer Pane, so it can be referenced by CSS
    this.getPanes().markerLayer.id='markerLayer'; 
  };
  myoverlay.setMap(map);

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
                       // console.log(results);
                          var res=results[0].geometry.location;
                         dis = getDistanceFromLatLonInKm(res.lat(), res.lng(), -33.837864, 151.02846769999996);

                         var latlong=[res.lat(), res.lng()];
                             //if()
                       var tempvar = ["QLD","NSW","TAS"];
                      

                           // alert(dis+'km');
                          //alert(res.lng());
                             
                            // rs.push([res.lat(),res.lng()]);
                            // alert(rs);
                           
                          //  console.log(rs);
                                var state = address.split(',');
                                var asl=state[0];
                                
                               
                        var marker_img = "<?php echo get_template_directory_uri();?>/images/location-bg.png";
                        var marker = new google.maps.Marker({
                            icon: marker_img,
                            map: map,
                            position: results[0].geometry.location,
                            title: title,
                            animation: google.maps.Animation.DROP,
                            address: address,
                            
                        })
                       
                        if((asl.toUpperCase() === tempvar[0].toUpperCase())|| (asl.toUpperCase() === tempvar[1].toUpperCase()) ){
                        var html = "<div class='map_info xyz'><div class='contents  modify'><h5>" + asl +'</h5>'+ "<h6 style='color:#000000 !important'>" + title  + "stores</h6><div class='custom_icon_right'></div></div></div>";
                           
                            var right_=1;

                    }
                    else if((asl.toUpperCase() === tempvar[2].toUpperCase())){
                         var html = "<div class='map_info xyz'><div class='contents  modify'><h5>" + asl +'</h5>'+ "<h6 style='color:#000000 !important'>" + title  + "stores</h6><div class='custom_icon_down'></div></div></div>";
                           
                            var right_=2;

                    }
                        else{
                            var html = "<div class='map_info ' ><div class='contents'><h5>" + asl +'</h5>'+ "<h6 style='color:#000000 !important'>" + title  + "stores</h6><div class='custom_icon'></div></div></div>";
                           
                           var right_=0;
                        }
                        //infoWindow(marker, map, title, address,asl);
                        console.log(latlong);
                         var infoBox = new InfoBox({
            latlng:marker.getPosition(),
            map: map,
            content: html,
            right__:right_
            
        });

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
    
     function InfoBox(opts) {
    google.maps.OverlayView.call(this);
    this.latlng_ = opts.latlng;
    this.map_ = opts.map;
    this.content = opts.content;
    this.offsetVertical_ = -100;
    this.offsetHorizontal_ =-50;
    this.height_ = 50;
    this.width_ = 80;
    this.right__=opts.right__;
    var me = this;
    this.boundsChangedListener_ =
        google.maps.event.addListener(this.map_, "bounds_changed", function () {
            return me.panMap.apply(me);
        });
    // Once the properties of this OverlayView are initialized, set its map so
    // that we can display it. This will trigger calls to panes_changed and
    // draw.
    this.setMap(this.map_);
}
/* InfoBox extends GOverlay class from the Google Maps API
 */
InfoBox.prototype = new google.maps.OverlayView();
/* Creates the DIV representing this InfoBox
 */
InfoBox.prototype.remove = function () {
    if (this.div_) {
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
    }
};
/* Redraw the Bar based on the current projection and zoom level
 */
InfoBox.prototype.draw = function () {
    // Creates the element if it doesn't exist already.
    this.createElement();
    if (!this.div_) return;
    // Calculate the DIV coordinates of two opposite corners of our bounds to
    // get the size and position of our Bar
    var pixPosition = this.getProjection().fromLatLngToDivPixel(this.latlng_);
    if (!pixPosition) return;
    // Now position our DIV based on the DIV coordinates of our bounds
    this.div_.style.width = this.width_ + "px";
    this.div_.style.left = (pixPosition.x + this.offsetHorizontal_) + "px";
    this.div_.style.height = this.height_ + "px";
    this.div_.style.top = (pixPosition.y + this.offsetVertical_) + "px";
    this.div_.style.display = 'block';
};
/* Creates the DIV representing this InfoBox in the floatPane. If the panes
 * object, retrieved by calling getPanes, is null, remove the element from the
 * DOM. If the div exists, but its parent is not the floatPane, move the div
 * to the new pane.
 * Called from within draw. Alternatively, this can be called specifically on
 * a panes_changed event.
 */
InfoBox.prototype.createElement = function () {
    var panes = this.getPanes();
    var div = this.div_; 
   
    if (!div) {
        // This does not handle changing panes. You can set the map to be null and
        // then reset the map to move the div.
        div = this.div_ = document.createElement("div");
            div.className = "infobox"
        var contentDiv = document.createElement("div");
        if(this.right__==1){
            contentDiv.className = "content_right";
        }
         else if(this.right__==2)
        {
         contentDiv.className = "content_down";
        }  
        else 
        { contentDiv.className = "content";}
         
            contentDiv.innerHTML = this.content;
        var closeBox = document.createElement("div");
            closeBox.className = "close";
            closeBox.innerHTML = "x";
        div.appendChild(closeBox);

        function removeInfoBox(ib) {
            return function () {
                ib.setMap(null);
            };
        }
        google.maps.event.addDomListener(closeBox, 'click', removeInfoBox(this));
        div.appendChild(contentDiv);
        div.style.display = 'none';
        panes.floatPane.appendChild(div);
        this.panMap();
    } else if (div.parentNode != panes.floatPane) {
        // The panes have changed. Move the div.
        div.parentNode.removeChild(div);
        panes.floatPane.appendChild(div);
    } else {
        // The panes have not changed, so no need to create or move the div.
    }
}
/* Pan the map to fit the InfoBox.
 */
InfoBox.prototype.panMap = function () {
    // if we go beyond map, pan map
    var map = this.map_;
    var bounds = map.getBounds();
    if (!bounds) return;
    // The position of the infowindow
    var position = this.latlng_;
    // The dimension of the infowindow
    var iwWidth = this.width_;
    var iwHeight = this.height_;
    // The offset position of the infowindow
    var iwOffsetX = this.offsetHorizontal_;
    var iwOffsetY = this.offsetVertical_;
    // Padding on the infowindow
    var padX = 40;
    var padY = 40;
    // The degrees per pixel
    var mapDiv = map.getDiv();
    var mapWidth = mapDiv.offsetWidth;
    var mapHeight = mapDiv.offsetHeight;
    var boundsSpan = bounds.toSpan();
    var longSpan = boundsSpan.lng();
    var latSpan = boundsSpan.lat();
    var degPixelX = longSpan / mapWidth;
    var degPixelY = latSpan / mapHeight;
    // The bounds of the map
    var mapWestLng = bounds.getSouthWest().lng();
    var mapEastLng = bounds.getNorthEast().lng();
    var mapNorthLat = bounds.getNorthEast().lat();
    var mapSouthLat = bounds.getSouthWest().lat();
    // The bounds of the infowindow
    var iwWestLng = position.lng() + (iwOffsetX - padX) * degPixelX;
    var iwEastLng = position.lng() + (iwOffsetX + iwWidth + padX) * degPixelX;
    var iwNorthLat = position.lat() - (iwOffsetY - padY) * degPixelY;
    var iwSouthLat = position.lat() - (iwOffsetY + iwHeight + padY) * degPixelY;
    // calculate center shift
    var shiftLng =
        (iwWestLng < mapWestLng ? mapWestLng - iwWestLng : 0) +
        (iwEastLng > mapEastLng ? mapEastLng - iwEastLng : 0);
    var shiftLat =
        (iwNorthLat > mapNorthLat ? mapNorthLat - iwNorthLat : 0) +
        (iwSouthLat < mapSouthLat ? mapSouthLat - iwSouthLat : 0);
    // The center of the map
    var center = map.getCenter();
    // The new map center
    var centerX = center.lng() - shiftLng;
    var centerY = center.lat() - shiftLat;
    // center the map to the new shifted center
    map.setCenter(new google.maps.LatLng(centerY, centerX));
    // Remove the listener after panning is complete.
    google.maps.event.removeListener(this.boundsChangedListener_);
    this.boundsChangedListener_ = null;
};  


    function infoWindow(marker, map, title,address,asl) {
        if (typeof (window.google) !== 'undefined' && google.maps) {
            
                var html = "<div class='map_info' style='height:40px;width:50px;padding-left:10px'><div class='contents'><h5 style='color:red;''>" + asl +'</h5>'+ "<h6 style='color:black !important'>" + title  + "Stores</h6><div class='custom_icon'></div></div></div>";

                iw = new google.maps.InfoBox({
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
<style>

.infobox {
  /* background: none repeat scroll 0 0 rgba(255,255,255,0.4); */
  color: #F1F1F1;
  font-family: arial;
  line-height: 50px;
  position: absolute;
  /* margin-top:80px; */ 
  z-index:1;
  margin-left:-20px;


}
      
/*
margin: 5px;
    position: relative;
    left: -21px;
    height: 50px;
    padding: 5px;
    top: 68px;
    width: 70px;
    background: red;
    .infobox:before, .infobox:after {
  border-color: transparent transparent transparent #212121;
  border-style: solid;
  border-width: 20px 20px 0;
  bottom: -1px;
  content: "";
  display: none;
  height: 0;
  left: -1px;
  position: absolute;

  width: 0;
  z-index:2
}
.infobox:after {
  border-color: transparent transparent transparent #FFFFFF;
  border-width:24px 24px 0;
  z-index:1
}
*/
.contents h5 {font:700 16px 'proxima_nova_ltsemibold', sans-serif; color:#c32327;}
.contents h6 {font:normal 12px 'proxima_nova_rgregular', sans-serif; color:#666666;}

.infobox .close {


cursor: pointer;
float: right;
font-size: 17px;
height: 25px;
line-height: 22px;
position: relative;
right: -25px;
text-align: center;
top: 0;
width: 25px;
display:none;

}


.infobox .content { 

 margin: 5px;
    position: relative;
    left: -6px;
    height: 40px;
    padding: 5px;
    top: 77px;
    width: 70px;
    background: rgba(255,255,255,0.5);padding-left:20px;
     border:2px solid #ddd; 
}

.infobox .content_right {
 margin: 5px;
    position: relative;
    left:60px;
    height: 40px;
    padding: 5px;
    top: 58px;
    width: 70px;
    background: rgba(255,255,255,0.5);
     border:2px solid #ddd; 
}
.infobox .content_down {
     margin: 5px;
    position: relative;
    left: 72px;
    height: 40px;
    padding: 5px;
    top: 86px;
    width: 70px;
    background: rgba(255,255,255,0.5);
    border: 2px solid #ddd;
}

div.custom_icon{
    background-image: url('<?php echo get_template_directory_uri();?>/images/location.png');
    background-repeat: no-repeat; 
    width:22px;
    height: 28px;
    position: absolute;
    right: -15px;
    top: -17px;
    z-index:20000 !important;
    display: inline-block;
}
div.custom_icon_right{
    background-image: url('http://localhost/carpetcall/wp-content/themes/carpetcall/images/location.png');
    background-repeat: no-repeat; 
    width: 22px;
    height: 28px;
    position: absolute;
    left: -12px;
    top: 1px;
    z-index: 20000 !important;
    display: inline-block;
}div.custom_icon_down{
background-image: url('http://localhost/carpetcall/wp-content/themes/carpetcall/images/location.png');
background-repeat: no-repeat; 
    width: 22px;
    height: 28px;
    position: absolute;
    left: -24px;
    top: -26px;
    z-index: 20000 !important;
    display: inline-block;}
.contents{
    
  color: #F1F1F1;
  font-family: arial;
  line-height: 50px;
  position: absolute;
  
  z-index:1;
 
  
}
  .maf_info{margin-left: 20px !important;}
  .store-map{
    zoom: 1.25;
    -moz-transform: scale(0.5);
}
.modify h5,.modify h6 {
    padding-left:15px;

}
</style>