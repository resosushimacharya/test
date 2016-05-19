<?php
/* Template Name: home */
 get_header();?>
<?php 
$about = 	/**
	 * The WordPress Query class.
	 * @link http://codex.wordpress.org/Function_Reference/WP_Query
	 *
	 */
	$args = array('post_type'=>'backgrounds' ,
		'posts_per_page'=>3);

$about = new WP_Query( $args );
if($about->have_posts()):
	while($about->have_posts()):
		$about->the_post();
         the_title();
         
         echo '<div class="">';
          the_post_thumbnail();
          echo '<h3>'.the_title().'</h3>';
          echo '<p>';
          the_excerpt();
          echo '</p></div>';
		endwhile;
endif;

?>    <button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

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
}
</script>  
<?php get_footer();?>
