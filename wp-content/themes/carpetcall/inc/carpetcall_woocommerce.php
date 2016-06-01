<?php remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
function my_theme_wrapper_start() {
echo '<section id="main">';
}
function my_theme_wrapper_end() {
echo '</section>';
}
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
add_theme_support( 'woocommerce' );
}
add_action('customize_register','carpetcall_sociallinks');
function extrafeature()
{
$ben=get_field('benefits',get_the_id());
$con=get_field('construction',get_the_id());
$rem=get_field('recommended_for',get_the_id());
echo $ben.'<br>';
echo $con.'<br>';
echo $rem;
echo  get_the_id();
echo "hello iam product";
}
add_action( 'woocommerce_after_shop_loop_item_title', 'extrafeature', 40 );
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
?>
<?php $count=0;
woocommerce_minicart_cc();
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
$count++;
endforeach;
echo $count;?>
<script>document.getElementById('count').innerHTML="<?php echo  json_encode($count)?>"</script>

<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total();
?>
</a>
<?php
$fragments['a.cart-contents'] = ob_get_clean();

return $fragments;
}
add_filter('woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text');
function woo_custom_cart_button_text() {
foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
	$_product = $values['data'];
	if( get_the_ID() == $_product->id ) {
		return __('Already in cart - Add Again?', 'woocommerce');
	}
}
return __('Add to cart', 'woocommerce');
}
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );
function woo_archive_custom_cart_button_text() {
foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
	$_product = $values['data'];
	if( get_the_ID() == $_product->id ) {
		return __('Already in cart', 'woocommerce');
	}
}
return __('Add to cart', 'woocommerce');
}
do_action( 'woocommerce_after_cart_totals','mytotal','10' );

function mytotal(){?>
<script>document.getElementById('carttotal').innerHTML="<?php echo  json_encode(wc_cart_totals_order_total_html());?>"</script>
 <?php 

}

//add_action( 'woocommerce_before_shop_loop', 'carpetcall_product_subcategories', 50 );

function carpetcall_product_subcategories($args=array())
{
	$parentid = get_queried_object_id();
         
$args = array(
    'parent' => $parentid
);
 
$terms = get_terms( 'product_cat', $args );
 
if ( $terms ) {
         
    echo '<ul class="product-cats">';
     
        foreach ( $terms as $term ) {
                         
            echo '<li class="category">';                 
                     
                woocommerce_subcategory_thumbnail( $term );
                 
                echo '<h2>';
                    echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
                        echo $term->name;
                    echo '</a>';
                echo '</h2>';
                                                                     
            echo '</li>';
                                                                     
 
    }
     
    echo '</ul>';
 
}
}
/*add_action( 'woocommerce_before_shop_loop_item_title', 'carpetcall_before_shop_loop_item_title' ,'51');
function carpetcall_before_shop_loop_item_title(){?>
	<li >

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php the_permalink(); ?>">

	
		
			<h3><?php the_title(); ?></h3>
 			<?php do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</a>

	

</li><?php
}*/
function carpetcall_woocommerce_template_loop_add_to_cart( $args = array() ) {
		global $product;

		if ( $product ) {
			$defaults = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( array(
						'buttons',
						'mywoos',

						'product_type_' . $product->product_type,
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
				) ) )
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			wc_get_template( 'loop/add-to-cart.php', $args );
		}
	}
	do_action('woocommerce_template_loop_add_to_cart','carpetcall_woocommerce_template_loop_add_to_cart','50');
	/*add_filter('woocommerce_loop_add_to_cart_link','add_to_cart_link_revised');

function add_to_cart_link_revised() {
    echo '<button class="qbutton add-to-cart-button button add_to_cart_button product_type_simple product_type_booking" id="carpetcall_cart">ADD TO CART</button>';
}*/
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
    if ($value['price_html'] == '') {
        $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }
    return $value;
}, 10, 3);