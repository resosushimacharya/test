<?php
/* 
** Template Name: Store Main page
*/
?>
<?php get_header();?>

<?php  ?>

<div class="cbg_blk cc-clearance-blk clearfix">
 <div class="container ">
<div class="inerblock_serc cc-wrapper-whole">
<div class="col-md-12">					
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display')){
        bcn_display();
    }?>

</div>
<h3><?php echo  get_the_title();?></h3>
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#find_your_nearest_store">FIND YOUR NEAREST STORE</a></li>
  <li class="google-map-load"><a data-toggle="tab" href="#head_offices">HEAD OFFICES</a></li>
  
</ul>

<div class="tab-content">
  <div id="find_your_nearest_store" class="tab-pane fade in active">
    <h3>HOME</h3>
    <p><?php echo do_shortcode('[wpsl]');?></p>
    <?php 
      $tax = 'wpsl_store_category';
      $tax_terms = get_terms($tax, array('hide_empty' => true));
     
      $regions = array(
        'QLD' => 'Queensland',
        'NSW' =>'New South Wales',
        'SA' =>'South Australia',
        'TAS'=>'Tasmania',
        'VIC'=>'Victoria',
        'WA'=>'Western Australia',
        'ACT'=>'Australia Capital Territory',
        'NT'=>'Northern Territory'
        );
      foreach($tax_terms as $term):
       
        echo '<div class="cc-state-link"><a href="'.get_category_link($term->term_id).'" >'.$regions[$term->name].'</a></div>';
        endforeach;



    ?>

  </div>
  <div id="head_offices" class="tab-pane fade">
    <div class="body-wrapper">
<div class="container ">
<div class="col-md-12">
<div id="<?php echo the_ID();  ?>">
 <div id="Map" style="width: 100%; height: 450px;"></div>

</div>
</div>
</div>
<div class="clearfix"></div>
<div class="container">
<!-- <div id="wpsl-wrap" class="wpsl-store-below wpsl-default-filters">
    <div id="wpsl-result-list">
        <div id="wpsl-stores"> -->
        <?php 

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
        ?>
         <ul>

        <?php   

          while($loop->have_posts()):
                $loop->the_post();

              $getinfo  = get_post_meta($post->ID);

                  $lat = $getinfo['wpsl_lat'];
                  $long = $getinfo['wpsl_lng'];
                  $stoLatLong=array($lat,$long);
                  $add = $getinfo['wpsl_address'][0];
                  $title = get_the_title();
                  $sll[] = array($title,$add,$stoLatLong);

           
    

        ?>
       
        <li class="col-md-4">
         <div>
            <p>
                <span class="cc-store-icon-label">
                    <img src="http://localhost/carpetcall/wp-content/themes/carpetcall/images/blue.png">
                    <strong>
                    <a href="http://localhost/carpetcall/find-a-store/wa//midland/"><?php echo get_the_title();?></a>
                    </strong>
                </span>
            </p>
            <div class="clearfix"></div>
            <span class="wpsl-street"><?php echo get_post_meta($post->ID,'wpsl_address',true );?></span>
                
            <span> Midland WA</span>
            <span class="wpsl-country"><?php echo get_post_meta($post->ID,'wpsl_country',true );?></span>
            <span><strong>P</strong>: <?php echo get_post_meta($post->ID,'wpsl_phone',true );?></span>
            <span><strong>F</strong>: <?php echo get_post_meta($post->ID,'wpsl_fax',true );?></span>
                
                
            <div class="fcnt-or fcnt-orr clearfix">
                <a href="<?php echo get_the_permalink();?>">View Store Page</a>
            </div>
            <div class="fcnt-or fcnt-orr fcnt-orr-map clearfix">
                <a href="http://localhost/carpetcall/contact-us/?id=<?php echo $post->ID ; ?>" class="cc-contact-link  ">Contact Store</a>
            </div>         
        </div>
       
        </li>
    <?php endwhile;
    wp_reset_query(); ?>
        </ul>
        </div>
    </div>
<!-- </div>
</div>
  </div> -->
  
</div>


</div>

</div>
</div>
</div>

<style>
.cc-wrapper-blk{
background:#f0f2f1 !important;
}
.cc-wrapper-whole h3{
	text-decoration:none !important;
	border:none;

}
.cc-contact-side{
	
}
.cc-form-wrapper{
	padding:5px;}
#wpsl-stores{
	overflow:visible !important;
}
.fcnt-orr-map a {
	background:#fff;
	border:1px solid #1858b8;
	color:#1858b8;
} 
.fcnt-orr-map a:hover{
background:#fff;
}

</style>


<?php 
get_footer();

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
    
  
    $('.google-map-load').click(function(e){

     setTimeout(function() { initialize(); }, 400);
    })
    
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
            disableDefaultUI: true
           
            
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
