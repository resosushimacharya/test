<?php 
/*
* Template Name: Map
*/
get_header();?>
<div class="body-wrapper">
<div class="container ">
<div class="col-md-12">
<div id="<?php echo the_ID();  ?>">
<div id="Map" style="width: 100%; height: 329px;">
</div>


<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN3lkABBKjsMdIzAyI1Rwy_6Z8cT8IEWc&libraries=places">
</script> 

<?php 

/* query the wpsl_stores post type to get the lat and lond and location name and title;
@extract meta field that holds value of respective fields.
*/
$args = array(
    'post_type'=>'wpsl_stores',
    'posts_per_page'=>'-1'

 

    );
$loop = new WP_Query($args);
while($loop->have_posts()):
$loop->the_post();
$getinfo  = get_post_meta($post->ID);

$lat = $getinfo['wpsl_lat'];
$long = $getinfo['wpsl_lng'];
$stoLatLong[]=array($lat,$long);
$add = $getinfo['wpsl_address'][0];
$title = get_the_title();
endwhile;
wp_reset_query();

?>
    <?php 

/* query the wpsl_stores post type to get the lat and lond and location name and title;
@extract meta field that holds value of respective fields.
*/
$sll = array();
$args = array(
    'post_type'=>'wpsl_stores',
    'posts_per_page'=>'-1'

 

    );
$loop = new WP_Query($args);
while($loop->have_posts()):
$loop->the_post();
$getinfo  = get_post_meta($post->ID);

$lat = $getinfo['wpsl_lat'];
$long = $getinfo['wpsl_lng'];
$stoLatLong=array($lat,$long);
$add = $getinfo['wpsl_address'][0];
$sll[] = array($title,$add,$stoLatLong);
$title = get_the_title();
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
    var locations = [];

    geocoder = new google.maps.Geocoder();
    
    $(document).ready(function () {
        setTimeout(function() { initialize(); }, 400);
    });
    
    function initialize() {   
    sll = [];        
        infowindow = [];
        markers = [];
   
        iterator = 0;
        areaiterator = 0;
        /*region = new google.maps.LatLng(-28.86944,153.04453);*/
        region = new google.maps.LatLng(-28,134);
        map = new google.maps.Map(document.getElementById("Map"), { 
            zoom: 4,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: region,
            
        });
        drop();
    }
    
  
            var locations = [
 <?php foreach ($sll as $item):
  ?>
                ['<?php echo $item[0]; ?>', "<?php echo $item[1];?>","<?php echo $item[2][0][0].','.$item[2][1][0] ;?> "],
    <?php endforeach; ?>

    ];
  
        

           
    function drop() {
        for (var i = 0; i < locations.length; i++) {
            setTimeout(function() {
                addMarker();
              console.log(locations[i]);
            }, 800);
        }
    }
 
    function addMarker() {
        var address = locations[areaiterator][1];
        var icons = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var templat = locations[areaiterator][2].split(',')[0];
        var templong = locations[areaiterator][2].split(',')[1];
        var temp_latLng = new google.maps.LatLng(templat, templong);
        var title = locations[areaiterator][0];
        markers.push(new google.maps.Marker(
        {
            position: temp_latLng,
            map: map,
            icon: icons,
            draggable: false,
            title:title
        }));            
        iterator++;
        info(iterator);
        areaiterator++;
    }
 
    function info(i) {
        infowindow[i] = new google.maps.InfoWindow({
            content:locations[i-1][0]+'<br/>'+locations[i-1][1],
         
        });
        infowindow[i].content = locations[i-1][1];
          infowindow[i].title = locations[i-1][0];
        google.maps.event.addListener(markers[i - 1], 'click', function() {
            for (var j = 1; j < locations.length + 1; j++) {
                infowindow[j].close();
            }
            infowindow[i].open(map, markers[i - 1]);
        });
    }
</script>
</div>
</div>
</div>
<style>
.body-wrapper{
        margin:150px 0 38px 0;
}
#Map {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
}
#Map {
    position: relative;
}
</style>


<?php get_footer(); ?>