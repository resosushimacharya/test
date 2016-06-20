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
<div class="contaniner clearfix">	<div class="inerblock_serc">
<div class="container">
<div class="col-md-3 cc-cat-pro-section-left">
</div>
<div class="col-md-9 cc-cat-pro-section-right">
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			
			
			<?php 
			// echo single_cat_title("",false) ;
			 global $wp_query;
			 //do_action('pr',$wp_query);
			// do_action('pr',$wp_query->posts);
			 $term_id =  get_queried_object()->term_id;

			 $childcats = get_categories('child_of=' . get_queried_object()->term_id . '&hide_empty=1');
			 //do_action('pr',get_queried_object());
			 $discats=get_terms(array('parent'=>$term_id,'taxonomy'=>'product_cat'));
			 //do_action('pr',$has_sub_cat);
                            foreach($discats as $discat){
                            	?>
                          
                            		<h3><?php woocommerce_page_title();?></h3><br />
                            		<?php
                            	echo '<h3>'.$discat->name.'</h3><br/>';?>
                            
                            	
                            	<?php 
									$filargs = array(
													'post_type'=>'product',
													'posts_per_page'=>'-1',
													'meta_key'=>'_sale_price',
													'orderby' => 'meta_value',
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
								$filloop = new WP_Query($filargs);
									$hold = 1;
								if($filloop->have_posts()){
									while($filloop->have_posts()):
										$filloop->the_post();

											/*var_dump($filloop->post->ID);*/


									?><div class="col-md-4 cc-other-term-pro">
										<?php the_post_thumbnail();
										
										
										$woo=get_post_meta($filloop->post->ID);
										/*
										echo '<h3>'.$discat->name.'</h3>';
										echo "<h5>FROM A$".$woo['_sale_price'][0].'</h5>';*/


										?>
										</div>


								<?php endwhile;?>
                     		<?php 
                     		wp_reset_query(); }?>
                     		</div>
                     		<br>
                     		<?php 
                     	}
			  ?>
		

		<?php endif; 
		?>
		</div></div></div>

<?php get_footer();?>