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
	?><div class="container">
<div class="col-md-12">
<?php 
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
</div></div>
<?php 

/* 
	* added section to wrap the container
	* wrapper open start 
*/
?>
<div class="container">
<div class="col-md-12">
<?php /*before-wrapper open  end */  ?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );

	?>

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
      <div class="cc-related-product-design-section">

      <h3>SELECT A DESIGN</h3>
      </div>
      <?php $pro = get_post_meta($post->ID);
      global $post;
      
       ?>
      <?php if(strcasecmp($pro['_stock_status'][0],'instock')!=0){?><div>
      <h3> OUT OF STOCK</h3>
      <?php do_action('cc_after_select_design_start');  do_action( 'woocommerce_single_product_summary' ); ?>
      </div><?php }?>
      <div class="cc-size-quantity-section">
      	<?php do_action('cc_size_quantity');
      	 do_action( 'woocommerce_single_product_summary' );
      	 $x=do_shortcode('[add_to_cart_url id="'.$post->ID.'"]');
      	 ?>
      	 <a href="<?php echo $x ;?>" data-quantity="1" data-product_id="<?php echo $post->ID;?>" data-product_sku="<?php
      	  echo $pro['_sku'][0] ; ?>" class="button product_type_simple add_to_cart_button ajax_add_to_cart" id="store-count-quantity" >ADD TO CART</a>
      	  <form class="cart" method="post" enctype="multipart/form-data">
	 	
	
	 	<input type="hidden" name="add-to-cart" value="<?php echo $post->ID;?>">

	 	<button type="submit" class="button product_type_simple add_to_cart_button ajax_add_to_cart single_add_to_cart_button button alt">Add to cart</button>

			</form>
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
		 do_action( 'woocommerce_after_single_product_summary' );
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
