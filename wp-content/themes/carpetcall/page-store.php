<?php 
get_header();


$stoLatLong= array();
$stoID=array();
$info= array();
$x= array("hello","nepal");
$args=array(
    'post_type'=>'wpsl_stores'
  );
$loop = new WP_Query($args);
while($loop->have_posts()):
$loop->the_post();
$sto=get_post_meta($post->ID,'',true);
$stoLatLong[]=array($sto['wpsl_lat'][0],$sto['wpsl_lng'][0]);
$info[]=$sto['wpsl_city'];
do_action('pr',$sto);
$stoID[]=get_the_permalink();

$unsearilize = unserialize($sto['wpsl_hours'][0]);



endwhile;

 ?>

<!--<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>



<script>
//geocoder = new google.maps.Geocoder();
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
   alert(sll);
    
}
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
</script>
<div id="Map" style="width: 921px; height: 329px;">
</div>
<p id="demo"></p>
<script type="text/javascript">
x = document.getElementById("demo");

function loadmap(){
  // //alert(myx);
  sll=<?php  echo json_encode($stoLatLong);?>;
  var city=<?php echo json_encode($info);?>;
  perm=<?php echo json_encode($stoID);?>;
  ////alert(sll);
   city.push(["my location"]);
   perm.push(["404"]);
   alert(perm);
  // //alert(city);
  //alert(myx);
  console.log(sll);
  console.log(city);
  console.log(perm);
    
  var contentstring = [];
  var regionlocation = [];
  var markers = [];
  var iterator = 0;
  var areaiterator = 0;
  var map;
  var infowindow = [];
  geocoder = new google.maps.Geocoder();
  
  $(document).ready(function () {
    setTimeout(function() { initialize(); }, 400);
  });
  
  function calculatePlaces()
{
  prakashArray = [];
  prakashLocation=[];
  
  console.log(myx);
  //console.log(allx);
  for(i = 0; i< sll.length; i++)
  {   dis = getDistanceFromLatLonInKm(sll[5][0], sll[5][1], sll[i][0], sll[i][1])
    if(dis<20)
    {    //alert(dis);
      alert(perm[i]);
      prakashArray.push({'lat': sll[i][0], 'long' : sll[i][1],'myloc':city[i],'stoperm':perm[i]});
      

    }
  }
    for(myobj in prakashArray){
      console.log(prakashArray[myobj]);
      //alert(prakashArray[myobj].myloc[0]);
    }
    //alert(prakashArray.length);

  console.log(prakashArray);

  //load the array items in map
}

  function initialize() {           
    infowindow = [];
    markers = [];
    GetValues();
    iterator = 0;
    areaiterator = 0;
    sll.push(myx);

    // //alert(sll);
    region = new google.maps.LatLng(myx[0], myx[1]);
    
    map = new google.maps.Map(document.getElementById("Map"), { 
      zoom: 9,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: region,
    });
    setTimeout(function() { calculatePlaces(); }, 400);
      
    setTimeout(function() { drop(); }, 400);
      
  }
  
  function GetValues() {
    //Get the Latitude and Longitude of a Point site : http://itouchmap.com/latlong.html
    contentstring[0] = "Ahmedabad, Gujarat, India";
    regionlocation[0] = '23.022505, 72.571362';
          
    contentstring[1] = "Gandhinagar, Gujarat, India";
    regionlocation[1] = "23.224820, 72.646377";
    
    contentstring[2] = "Andheri East, Mumbai, india";
    regionlocation[2] = "19.115491, 72.872695";
    
    contentstring[3] = "Pune, india";
    regionlocation[3] = "18.520430, 73.856744";
    
    contentstring[4] = "Chennai, india";
    regionlocation[4] = "13.082680, 80.270718";
    
    contentstring[5] = "Visakhapatnam, Andhra Pradesh, india";
    regionlocation[5] = "17.686816, 83.218482";
    
  }
       
  function drop() {
    
    for (var i = 0; i < prakashArray.length; i++) {

              
      setTimeout(function() {
        addMarker();
      }, 800);
      /*setTimeout(function() {
        info(i);
      }, 800);*/
    }
  }
 
  function addMarker() {
    //var address = contentstring[areaiterator];
    
        var address = prakashArray[areaiterator].myloc[0];
        
        if(areaiterator==prakashArray.length-1){
    var icons = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';}
    
        template = prakashArray[areaiterator].lat;
        //alert(template);
        
    //var templong = sll[areaiterator].split(',')[1];
     templong = prakashArray[areaiterator].long;
    

    var temp_latLng = new google.maps.LatLng(template, templong);
    markers.push(new google.maps.Marker(
    {
      position: temp_latLng,
      map: map,
      icon: icons,
      draggable: false
    }));            
    iterator++;
    info(iterator);
    areaiterator++;
  }
 
  function info(i) {
    //alert(prakashArray[i-1].stoperm);
    //var mycontent =prakashArray[i-1].myloc[0]+'('+prakashArray[i-1].lat+','+prakashArray[i-1].long+')'+
      //'< a hef="'+prakashArray[i-1].stoperm+'">click here</a>';
      var mycontent= '<div id="content" style="width:400px; background-color:red;">' +'<a href="'+prakashArray[i-1].stoperm+'"'+'>'+'hello'+'</a>'+'</br>'

                'My Text comes here' + 
                '</div>';
    infowindow[i] = new google.maps.InfoWindow({

      content: mycontent,
      maxwidth:300
    });
    infowindow[i].content = mycontent;
    google.maps.event.addListener(markers[i - 1], 'click', function() {
      for (var j = 1; j < prakashArray.length + 1; j++) {
        infowindow[j].close();
      }
      infowindow[i].open(map, markers[i - 1]);
    });
  }
}
</script>
<?php

get_footer();

?>