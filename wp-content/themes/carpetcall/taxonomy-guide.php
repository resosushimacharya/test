<?php get_header();
/**
  * Template tag for breadcrumbs.
  *
  * @param string $before  What to show before the breadcrum
  * @param string $after   What to show after the breadcrumb.
  * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
  * @return string
  */
?>
<?php
$tax = 'guide';

$link = rtrim($_SERVER['REQUEST_URI'],'/');
$link =ltrim($link,'/');
$linkarr= explode('/',$link);
$len = count($linkarr);
$termname= $linkarr[$len-1];
$guideID = '1167';
$custompost= get_post($guideID);


 ?>
 <div class="cbg_blk clearfix">
 <div class="container">
<div class="inerblock_serc">
					
					
					 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>

</div>
<h3><?php echo $custompost->post_title;?></h3></div>
</div>
</div>


 <div class="container clearfix">
	<div class="inerblock_serc">
		<div class="col-md-3">
			<?php get_sidebar('guide');?>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-9">
			
			 <?php echo  apply_filters('the_content',$custompost->post_content);?>
		</div>
</div>
</div><div class="container clearfix">
<div class="inerblock_serc">
					<ul>
					
		
					<?php
					
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'guides',
					"$tax" => $termname,
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'ignore_sticky_posts'=> 1
					);
					//echo $tax_term->slug;
					$my_query = null;
					$my_query = new WP_Query($args);
					while ($my_query->have_posts()) : $my_query->the_post();
					
					?>

                   
                    
					<?php 

					$reqTempTerms=get_the_terms($post->ID,$tax);
					       
					
					foreach($reqTempTerms as $reqTerm){ 
						  
						  if(strcasecmp($reqTerm->name,$termname)==0){?>
						  <?php 	//echo '<li>'.$reqTerm->name.'</li>';
						  	
						  
						  	the_title();
						  	the_content();?>
						  	<a href="<?php the_permalink();?>">click here</a>
						  	<?php }
					}
					
					?>
					
				
					
               <?php

					endwhile;
					wp_reset_query();
					?>
					</ul>
						</div>
</div><div class="clearfix"></div>
<div class="container clearfix">
<div class="inerblock_serc">
<div class="col-md-12"><h3 style="text-align:center">YOU MAY ALSO LIKE</h3></div>
<div class="col-md-12">

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
<?php 
get_footer();
?>