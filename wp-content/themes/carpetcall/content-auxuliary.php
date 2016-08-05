<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script><?php

/* query the wpsl_stores post type to get the lat and lond and location name and title;
@extract meta field that holds value of respective fields.
*/
$sll = array();
$args = array(
    'post_type'=>'wpsl_stores',
    'posts_per_page'=>'-1',
     'meta_query' => array (
            array (
              'key' => 'store_type',
              'value' => 'head_office',
            )
          )

 

    );
$loop = new WP_Query($args);
while($loop->have_posts()):
$loop->the_post();
$getinfo  = get_post_meta($post->ID);

$lat = $getinfo['wpsl_lat'];
$long = $getinfo['wpsl_lng'];
$stoLatLong=array($lat,$long);
$add = $getinfo['wpsl_address'][0];
$title = get_the_title();
$phone = '-';
$fax = '-';
$zip ='';
$state = '';
$city = '';
$direction = '';
if(array_key_exists('wpsl_phone',$getinfo)){
 $phone = $getinfo['wpsl_phone'][0];
}
if(array_key_exists('wpsl_phone',$getinfo)){
 $fax = $getinfo['wpsl_fax'][0];
}
if(array_key_exists('wpsl_city',$getinfo)){
  $city  = $getinfo['wpsl_city'][0];
}
if(array_key_exists('wpsl_state',$getinfo)){
 $state = $getinfo['wpsl_state'][0];
}
if(array_key_exists('wpsl_zip',$getinfo)){
 $zip = $getinfo['wpsl_zip'][0];
}
$combcsz =$city.' '.$state.' '.$zip;
$title ='<li class="cc-head-wpsl-title">'.$title .'</li>';
$add ='<li class="cc-head-wpsl-title">'.$add .'</li>';
$combcszsec ='<li class="cc-head-wpsl-csz">'.$combcsz.'</li>';
$phonesec = '<li class="cc-head-wpsl-phone">P: '.$phone.'</li>';
$faxsec = '<li class="cc-head-wpsl-fax">F: '.$fax.'</li>';
$direction =$combcsz;
$directionurl ="https://www.google.com/maps?saddr=&daddr=".$direction;
$directionlink ='<li  class="cc-head-wpsl-dir"><a  href="'.$directionurl .'" target="_blank" >GET DIRECTIONS</li>';
$sll[] = array($title,$add,$stoLatLong,$phonesec,$faxsec,$combcszsec,$directionlink);


endwhile;
wp_reset_query();

?>
<script type="text/javascript">
    var contentstring = [];
    var regionlocation = [];
    var markers = [];
    var iterator = 0;
    var areaiterator = 0;
    var map;
    var infowindow = [];
    var locations1 = [];

     locations1 = [
 <?php foreach ($sll as $item):
  ?>
                ['<?php echo $item[0]; ?>', '<?php echo $item[1];?>','<?php echo $item[2][0][0].','.$item[2][1][0] ;?>','<?php echo $item[3];?>','<?php echo $item[4];?>','<?php echo $item[5];?>','<?php echo $item[6];?>'],
    <?php endforeach; ?>

    ];
    console.log(locations1);

    geocoder = new google.maps.Geocoder();
    
  
   
     setTimeout(function() { initialize1(); }, 1000);
    
    function initialize1() {   
    sll = [];        
        infowindow1 = [];
        markers1 = [];
   
        iterator = 0;
        areaiterator = 0;
        /*region = new google.maps.LatLng(-28.86944,153.04453);*/
        region1 = new google.maps.LatLng(-28,134);
        map1 = new google.maps.Map(document.getElementById("Map"), { 
            zoom: 4,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: region1,
            disableDefaultUI: true
           
            
        });
        drop();
    }
    

  
        
       // console.log(locations);

           
    function drop() {
        for (var i = 0; i < locations1.length; i++) {
            setTimeout(function() {             
                addMarkers1();             
            }, 800);
        }
    }
    function addMarkers1() {
        var address = locations1[areaiterator][1];

        var icons = 'http://localhost/carpetcall/wp-content/themes/carpetcall/images/blue.png';
        var templat = locations1[areaiterator][2].split(',')[0];
        var templong = locations1[areaiterator][2].split(',')[1];
        var temp_latLng = new google.maps.LatLng(templat, templong);
        var title = locations1[areaiterator][0];
        markers1.push(new google.maps.Marker(
        {
            position: temp_latLng,
            map: map1,
            icon: icons,
            draggable: false,
            title:title
        }));            
        iterator++;
        infos(iterator);
        areaiterator++;
    }
 
    function infos(i) {
        infowindow1[i] = new google.maps.InfoWindow({
            content:'<div class="cc-head-infobox"><ul class="cc-head-infobox-list">'+locations1[i-1][0]+locations1[i-1][1]+locations1[i-1][5]+locations1[i-1][3]+locations1[i-1][4]+locations1[i-1][6]+'</ul></div>'
         
        });
        infowindow1[i].content = locations1[i-1][1];
          
        google.maps.event.addListener(markers1[i - 1], 'click', function() {
            for (var j = 1; j < locations1.length + 1; j++) {
                infowindow1[j].close();
            }
            infowindow1[i].open(map1, markers1[i - 1]);
        });
    }
</script>