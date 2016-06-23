<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<div class="contaniner clearfix">	<div class="inerblock_seC_mrugss">
<div class="container-fluid mmrugm"><div class="container">
<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
	<h3><span class="ab_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></span><?php echo single_cat_title('',false).' '.$appafter;?></h3>
    </div></div>
    
    
    
<div class="container">

    
    
<div class="tophead_sec col-md-12 no-lr">
<?php $term_id =  get_queried_object()->term_id;
$currentcat = get_queried_object();
?>
<div class="rugm-blk col-md-6 no-pl">
	<p>
		<span class="cc-cat-title-count">
			<?php echo $currentcat->count;?>
			<?php echo single_cat_title('',false).' '.$appafter;?>
			Products 
		</span>
		<span class="cc-count-clear"><a href="javascript:void(0)">CLEAR ALL</a></span>
	</p>
	
</div>

<div class="col-md-6 no-pr">
<div class="pull-right cc-product-sort">
	<?php do_action( 'woocommerce_before_shop_loop' ); ?>
	 </div>
</div>
</div>


<div class="cc-cat-pro-section-left col-md-3 no-lr">
<?php get_sidebar('pro-subcategory');?>


</div>
<div class="col-md-9 cc-cat-pro-section-right">
	

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			
			
			<?php 
			
			 global $wp_query;
		
			 $term_id_sub =  get_queried_object()->term_id;
			 $term_name = get_queried_object()->name;
			


			 
			 $discats=get_terms(array('parent'=>$term_id,'taxonomy'=>'product_cat'));
                do_action('pr',$discats);           
				$loopcounter = 0;?> <?php 
                            foreach($discats as $discat){
                            	if($loopcounter==2){
                            		break;
                            	}
                            	$loopcounter++;
                            	?>
                          <div class="row ">
                            		<div class="col-md-6"><h3><?php woocommerce_page_title();?></h3><br />
                            		<?php
                            	echo '<h3>'.$discat->name.'</h3><br/>';
                            	 ?>
                            	</div>
                            
                            	
                            	<?php 

									$filargs = array(
													'post_type'=>'product',
													'posts_per_page'=>'10',
													'meta_key'=>'_sale_price',
													'orderby' => 'meta_value_num',
													 'order'     => 'ASC',
													'tax_query' => array(
																		array(
																			'taxonomy' => 'product_cat',
																			'field'    => 'term_id',
																			'terms'    => $discat->term_id,
																		),
																	),
																
													);
									 wp_reset_postdata();
									 $pch = 1;
								$filloop = new WP_Query($filargs);
									$hold = 1;

								if($filloop->have_posts()){
									while($filloop->have_posts()):
										$filloop->the_post();
 										 $feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
											/*var_dump($filloop->post->ID);*/

                                          if($pch==1){
                                             $res = get_post_meta($post->ID ,'_sale_price',true);
                                             echo '<div class="col-md-6">From A$'.$res.'</div></div> <div class="row">';

                                             $pch++;
                                          }

									?><div class="col-md-4 cc-other-term-pro">
									<div class="cc-img-wrapper">
									<img src="<?php echo $feat_image;?>"/>
										<?php
										
										
										$woo=get_post_meta($filloop->post->ID);
										/*
										echo '<h3>'.$discat->name.'</h3>';
										echo "<h5>FROM A$".$woo['_sale_price'][0].'</h5>';*/


										?>
										<a href ="<?php the_permalink();?>" class="cc-pro-view">VIEW</a>
										</div>
										</div>


								<?php endwhile;?>
                     		<?php 
                     		wp_reset_query(); }?>
                     		
                     		</div>
                     		<?php 
                     	}
			  ?>
		<div class="woo-added"></div>
		<input type="button" name="cc_load_more" id ="cc_load_more" value="load more"/>
		<input type="hidden" id="cc_count" value="<?php echo $loopcounter ;?>"></div>
		<input type="hidden" id="category_name" value="<?php echo $term_name ;?>">
		<input type="hidden" id="category_id" value="<?php echo $term_id_sub ;?>"></div>
		
</div>
		<?php endif; 
		?>
		</div></div></div>

<style>
.cc-img-wrapper a.cc-pro-view {
	position:absolute;
	top:50%;
	left:50%;
	/* transform:translate(-50%,-50%); */
	cursor:pointer;

}
/* a.cc-pro-view:hover{
	display:block;
}
 */
.cc-product-sort ul{
	list-style:none;

}
.cc-product-sort li{
	float:left;
	padding:5px 10px;
}
</style>
<?php get_footer();?>