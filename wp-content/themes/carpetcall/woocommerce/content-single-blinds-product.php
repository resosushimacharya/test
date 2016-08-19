<div class="product_single_container">
<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	?>
    <div class="container">
<div class="col-md-12">
<?php 
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
</div>
</div>
<?php 

/* 
	* added section to wrap the container
	* wrapper open start 
*/
?>
<div class="container">
<div class="col-md-12 no-lr">


<?php
global $post;
global $product;
$product = wc_get_product($post->ID);

$reqTempTerms=get_the_terms($post->ID,'product_cat');
if($reqTempTerms){
	foreach($reqTempTerms as $cat){
		$has_sub_cat=get_terms(array('parent'=>$cat->term_id,'taxonomy'=>'product_cat'));
		if(count($has_sub_cat)==0){
			global $current_post_term_id;
			$current_post_term_id = $cat->term_id;
		}
	}
}
						
						



?>
<?php /*before-wrapper open  end */  ?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		
		
		do_action( 'woocommerce_before_single_product_summary' );?>
		
		
	
	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */

			do_action('cc_woocommerce_single_product_summary');
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_carpets_blinds_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_carpets_blinds_title', 10 );
			

			do_action( 'woocommerce_single_product_summary' );
            do_action('cc_woocommerce_single_product_summary_remove');
    //do_action('cc_after_select_design_start');

             //do_action( 'woocommerce_single_product_summary' );
			// remove action woocommerce_single_product_summary
			// add action cc_woocommerce_single_product_summary
			// insert woocommerce_output_related_products();
			
			
		
		?>
     <?php 
      /**
       *Select a design section 
       *here we show the related products image and links
      */ ?>
      <div class="carpet_blinds_single_right">
                 
                 <h3 class="calspl calspll">
                          <?php 
                             $telephone_link =  get_field('telephone_link', '89',false); 
                             $x = preg_replace('/\s+/', '', $telephone_link);
                             $x = preg_replace( '/^[0]{1}/', '', $x );
                             $i = 1;
                             $x = '+61'.$x;   
                          ?>
                          <a href="tel:<?php echo $x; ?>"><?php echo __( 'CALL ', 'carpetcall' ) . $telephone_link;?></a>
                        </h3>
                <h4 class="bcwfsp"><?php echo get_field('footer_contact_title_label',89);?> </h4>
                
                <div class="againlt">
                    <ul>

                        <?php $booklink=get_field('contactlink',89);?>
                        <?php
                            foreach($booklink as $singlelink){

                                 echo '<li> - ' . $singlelink['ask_an_expert'] . '</li>';
                            }
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                
      
      
      <?php $pro = get_post_meta($post->ID);
      global $post;
       ?>
      <div class="cc-product-enquiry col-md-12">
      	<button type="button" class="btn btn-default col-md-12" data-toggle="modal" data-target="#myModal2">ENQUIRE NOW</button>
      </div>
      
      <div class="clearfix"></div>
      
       </div>

	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
		do_action( 'woocommerce_after_single_product_summary' );
		add_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);

		//woocommerce_output_product_data_tabs();
		
		// as per design , this section appears in [] page
		
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->
<?php /* added section to wrap the container
wrapper close start */?>

</div></div>
<?php /* before-wrapper close end*/?>
<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php

	wp_reset_query();
	global $post;
	$you_may_like_prods = array();
	//$reqTempTerms=get_the_terms($post->ID,'product_cat');
	$second_lvl_cat = get_term_by('id',$current_post_term_id,'product_cat');
	$you_may_like_cats = get_term_children( $second_lvl_cat->parent, 'product_cat' );
	if(count( $you_may_like_cats ) > 0 ){
		$count =1;
		
		foreach($you_may_like_cats as $cat){
			if($cat != $second_lvl_cat->term_id){
				$args = array(
							'post_type'=>'product',
							'posts_per_page'=>1,
							'meta_key'		=>'_regular_price',
							'order_by'		=>'meta_value_num',
							'order'			=>'ASC',
							'tax_query'	=>array(
										array(
											'taxonomy' => 'product_cat',
											'field'    => 'term_id',
											'terms'    => $cat,
										)
									)
								);
			$like_prod = new WP_Query($args);
			if($like_prod->have_posts()){
				foreach($like_prod->posts as $post){
						if($count >3){
						break;
						}
				$you_may_like_prods	[$cat] =  $post;
				$count++;
				}
				}
			}
		}
	}
					
					?>
    
 <?php if(count($you_may_like_prods) >0){?>
	 <div class="inerblock_sec_a">
    <div class="container clearfix you_may_link_cntr">
        <h3 style="text-align:center">YOU MAY ALSO LIKE</h3>
<div class="you_may_like-content">
	<?php 
				foreach($you_may_like_prods as $key=>$post){
					setup_postdata($post);
					$woo=get_post_meta($post->ID);
					$price=$woo['_regular_price'][0];
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
									?> <div class="col-md-4">
                  		<div class="pro_secone">
                  		<a href="<?php the_permalink();?>" class="cc-product-item-image-link"><div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div></a>
                  
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="mero_itemss">
                      		<div class="proabtxt">
					 <a href="<?php the_permalink();?>" class="cc-product-item-title-link"><h4>
					<?php $term = get_term_by('id',$key,'product_cat');
					echo $term->name;?>
					</h4></a><?php 
					if(!empty($price)){
						echo '<h6> FROM A$'.$price.'</h6>';
						}?></div>
					<div class="clearfix"></div>
                      </div>
                      </div></a>
                      </div>
								<?php
								$count++; }?>
                     		<?php 
                     		wp_reset_query(); 
	?>
</div>
<div class="clearfix"></div>
               
    </div>
    </div>
	<?php }?>   
    
    
<style>
  #cc-enquiry-type{display:none;}
  .success_message_wrapper{display:none;}
</style>

</div>