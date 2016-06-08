<?php 
get_header();?>

<div class="container clearfix">
<div class="inerblock_serc">
<?php
$ben=get_field('benefits',get_the_id());
$con=get_field('construction',get_the_id());
$rem=get_field('recommended_for',get_the_id());
echo $ben.'<br>';
echo $con.'<br>';
echo $rem;
echo  get_the_id();
echo'<h1>display cart count</h1>';?>
<div id="counts"></div>
<?php //do_action( 'woocommerce_before_cart_totals' ); ?>
<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
<?php echo WC()->cart->get_cart_total(); ?></a>
hello<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>hello
<?php  
	//echo do_action('pr',WC()->cart->get_cart());
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				

					


					
						<?php
							if ( ! $_product->is_visible() ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
				
				
						<?php 
						echo $cart_item['quantity'].'*';
							
						?>
				


					
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
			

					
					
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );?>
					
				
				<?php
			}
		}

woocommerce_content();?>

</div>
</div><div class="clearfix"></div>
<?php 
get_footer();
// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
?>