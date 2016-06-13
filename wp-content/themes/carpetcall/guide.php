<?php 
/* Template Name: guide */
 get_header();
 ?>

<div class="container clearfix">
	<div class="inerblock_serc">
		<div class="col-md-2">
			<?php get_sidebar();?>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-10">
			<?php while(have_posts()):the_post()?>
	     	<h3><?php  the_title(); ?><h3>
	     	<p><?php the_content();?></p>
	        <?php endwhile;?>
		</div>
</div>
</div>
<div class="container clearfix">
<div class="inerblock_serc">
<div class="col-md-12">
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>
</div>
<?php
$tax = 'product_cat';
 ?><?php
						

						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'product',
					
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'ignore_sticky_posts'=> 1
					);
					//echo $tax_term->slug;
					$my_query = null;
					$my_query = new WP_Query($args);
					while ($my_query->have_posts()) : $my_query->the_post();
					$woo=get_post_meta($post->ID);
					
					$price=$woo['_regular_price'][0];
					
					
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					
					/*if(!empty(unserialize($woo['_product_attributes'][0])))
				$prounits=unserialize($woo['_product_attributes'][0]);*/
				
				if(isset($prounits['size']['value'])){
					$prounit=$prounits['size']['value'];
				}
               ?>
                     <?php  if($woo['_featured'][0]=='yes'){ ?>
                   <div class="col-md-4">
                  
                  		<div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div>
                  
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="sublk_prom">
                      		<div class="ptxt">
					<h3><?php
					the_title();?></h3><?php 

					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					

					

					
					if(!empty($price)){
						echo '<h5> FROM A$'.$price.'</h5>';
						
						}?></div>
					<div class="clearfix"></div>
                           
                      </div>
                      </div>
                      <?php }?>
					
               <?php

					endwhile;
					wp_reset_query();
					?><div class="clearfix"></div>
					</div></div>
					</div>

<?php get_footer();?>
?>