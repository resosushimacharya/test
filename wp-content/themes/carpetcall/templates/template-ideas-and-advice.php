<?php
/* Template Name: ideas and advice*/
get_header();
global $post;

/* ideas and advice child id declaration */
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  $bgID = 1690;
  $proID = 1711; 
  $faqID = 1725;
}
else{
  $bgID = 26696;
  $proID = 26709; 
  $faqID = 26721;
}

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );


?>
<div class="body-wrapper">
<div class="ia-block clearfix">
<div class="container">
        <div class="col-md-6 no-pl cc-ia-content">
        <h4><?php the_title();?></h4>
        <h1><?php the_title();?> </h1>
        <p><?php echo $post->post_content;?> </p>
        </div>
        <div class="col-md-6 ia-img">
         <div class="cc-ia-banner" style="background-image: url(<?php echo $feat_image ;?>);">	
         </div>
        </div>
</div>
</div><!-- uppper section end here -->


<div class="gpf-block clearfix">
<div class="container">
<div class="row cc-ia-item-cover">
<?php
$iadata = get_field('ideas_and_advice_page_fields');

function order_of_ideas_and_advice_function($a, $b) {
    return $a['order_of_ideas_and_advice'] - $b['order_of_ideas_and_advice'];
}
usort($iadata, 'order_of_ideas_and_advice_function');
/*do_action('pr',$iadata);*/
foreach($iadata as $iad){?>
    <?php if(strcasecmp($iad['category'],'More')==0):?>
	<div class="col-md-6 cc-ia-item cc-ia-more">
    <div class="more-blk-b">
		<h3><?php echo $iad['title'];?></h3>
		<?php echo $iad['description'];?>
        </div>
	</div>
    <?php 
    /**
    *reading the category
    *relating with our category such as guide,faq and product care  
    *it must include in else section(exlusion of More category)
    */
    $descats=get_terms(array('slug'=>$iad['category'],'taxonomy'=>'product_cat'));
    
    ?><?php elseif(strcasecmp($iad['category'],'Buying Guides')==0):?>
       <div class="col-md-6 cc-ia-item">
       <div class="all-items-blk">
    <a href="<?php echo get_the_permalink($bgID);?>"><h3><?php echo $iad['title'];?></h3></a>
    <p><?php echo $iad['description'];?></p>
      <ul class="cat_list"><?php  $args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $bgID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '</a></li>';
}
wp_reset_query();?>
</ul><div class="clearfix"></div>
</div>
</div>
    <?php elseif(strcasecmp($iad['category'],'Product Care')==0):
      $tax = 'product_care';

   
    $res_tax=strtolower($tax);
     $tax_terms = get_terms($res_tax);?>
     <div class="col-md-6 cc-ia-item">
     <div class="all-items-blk">
		<a href="<?php echo get_the_permalink($proID);?>"><h3><?php echo $iad['title'];?></h3></a>
		<p><?php echo $iad['description'];?></p>

            <ul class="cat_list">
            <?php  $args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $proID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '</a></li>';
}
wp_reset_query();?>
            </ul>
	</div>
    </div>
     <?php 
    
    else:
   
    $tax = explode("'",$iad['category']);

   
    $res_tax=strtolower($tax[0]);
     $tax_terms = get_terms($res_tax);

    
    ?>
   
    <div class="col-md-6 cc-ia-item">
    <div class="fq-blk-a">
		<a href="<?php echo get_the_permalink($faqID);?>"><h3><?php echo $iad['title'];?></h3></a>
		<p><?php echo $iad['description'];?></p>
		  
            
            
            <ul class="cat_list">
            <?php
                          
						
						$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $faqID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '</a></li>';
}
wp_reset_query();
				?>
            </ul>
            
            </div>
	</div>
<?php 
endif;
}
 ?>

</div>
</div>
</div>
</div>


<script>
  $(".cc-ia-more ul li ").append('<i class="fa fa-caret-right" aria-hidden="true"></i>');
</script>

<?php 
get_footer();
?>