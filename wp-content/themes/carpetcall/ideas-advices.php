<?php
/* Template Name: ideas and advice*/
get_header();
global $post;

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>
<div class="body-wrapper">
<div class="container">
	<div class="ideas-advice-section row">
        <div class="col-md-6 cc-ia-content">
        <h4><?php the_title();?></h4>
        <h1><?php the_title();?> </h1>
        <p><?php echo $post->post_content;?> </p>
        </div>
        <div class="col-md-6">
         <div class="cc-ia-banner">
          <img src="<?php echo $feat_image;?>" class="img-responsive">


      
         	
         </div>
        </div>
	</div>
</div>
<div class="container">
<div class="row cc-ia-item-cover">
<?php
$iadata = get_field('ideas_and_advice_page_fields');

function order_of_ideas_and_advice_function($a, $b) {
    return $a['order_of_ideas_and_advice'] - $b['order_of_ideas_and_advice'];
}
usort($iadata, 'order_of_ideas_and_advice_function');
foreach($iadata as $iad){?>
    <?php if(strcasecmp($iad['category'],'More')==0):?>
	<div class="col-md-6 cc-ia-item">
		<h3><?php echo $iad['title'];?></h3>
		<p><?php echo $iad['description'];?></p>
	</div>

    <?php else:
    ?>
   
    <div class="col-md-6 cc-ia-item">
		<h3><?php echo $iad['title'];?></h3>
		<p><?php echo $iad['description'];?></p>
	</div>
<?php 
endif;
}
 ?>

</div>
</div>
</div>
<style>
.body-wrapper{
		margin:150px 0 38px 0;
}
</style>


<?php 
get_footer();
?>