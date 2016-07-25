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
add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
function remove_product_description_heading() {
return '';
}
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['faq_tab'] = array(
		'title' 	=> __( "FAQ'S", 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content'
	);

	return $tabs;

}
function woo_new_product_tab_content() {?>

<?php $prourl = site_url();
      $prourl =explode('/',$prourl);
      if(strcasecmp($prourl[2], 'localhost')==0){
      	$profaqid = '1725';
      }
      else{
      	$profaqid = '26721';

      }
      ?>
      

     <div class="cont-panl">
			<div class="panel-group" id="accordion">
<?php
global $post;
$listcat=get_the_terms($post->ID,'product_cat');

foreach($listcat as $cat){
	if($cat->parent==0){
		//echo "that's the correct answer";
		$root = $cat->slug;
		$rootname = $cat->name;
	}
	else{
		//echo "that's the bullshit answer";
	}
}
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $profaqid,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'name' => $root

 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    $faqid =$post->ID;

}
wp_reset_query();

$list = get_field('buying_guide_archive',$faqid );

?>
					
					<?php
					
					 $faqcounter = 1;
					foreach($list as $listitem):
					

					
					
					?>

					      
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $faqcounter;?>">
          <span class="pull-right glyphicon <?php echo ($faqcounter==1)?'glyphicon-chevron-up':'glyphicon glyphicon-chevron-down'?>"></span>
          <?php echo $listitem['title'];?>
        </a>
      </h4>
    </div>
    <div id="collapse_<?php echo $faqcounter;?>" class="panel-collapse collapse <?php echo ($faqcounter==1)?'in':'' ;?> ">
      <div class="panel-body">
      <p>
        <?php echo $listitem['description']?>
        </p>
      </div>
    </div>
  </div>
		
			<?php 
			$faqcounter++;
						if($faqcounter==6){
				break;
			}

			endforeach;
			?>	
					
               
					
				</div></div>
  <div class="">
  	<p>For more answers to your questions, please refer to our <a href="<?php echo get_the_permalink($faqid ); ?>"><?php echo $rootname; ?> FAQ page</a></p>
  </div>
<?php	
}
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

     unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
	$tabs['additional_information']['title'] = __( 'DETAILS' );	// Rename the additional information tab

	return $tabs;

}
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab_care' );
function woo_new_product_tab_care( $tabs ) {
	
	// Adds the new tab
	
	$tabs['care_tab'] = array(
		'title' 	=> __( 'CARE INSTRUCTIONS', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content_care'
	);

	return $tabs;

}
function woo_new_product_tab_content_care() {?>
<?php global $product;
global $post;
$careins = get_field('care_instructions',$post->ID);
if(!empty($careins)){
	echo '<p>'.$careins.'</p>';
}
?>

<?php }?><?php 
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab_ret',96 );
function woo_new_product_tab_ret( $tabs ) {
	
	// Adds the new tab
	
	$tabs['ret_tab'] = array(
		'title' 	=> __( 'RETURNS', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content_ret'
	);

	return $tabs;

}
function woo_new_product_tab_content_ret() {?>
<?php global $product;
global $post;

$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  $retID = 31856;
 

}
else{
  $retID = 31856;
}
$retinfo = get_field('return_policy',$retID);
echo '<p>'.$retinfo.'</p>';

?>

<?php }?><?php 
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

	$tabs['additional_information']['priority'] = 5;			// Reviews first
	$tabs['care_tab']['priority'] = 10;			// Description second
	$tabs['faq_tab']['priority'] = 15;
	$tabs['ret_tab']['priority'] = 20; 	// Additional information third

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_custom_information_tab', 98 );
function woo_custom_information_tab( $tabs ) {

	$tabs['additional_information']['callback'] = 'woo_custom_information_tab_content';	// Custom description callback

	return $tabs;
}

function woo_custom_information_tab_content() {
    global	$post;
	echo '<h2 class="detail-heading-item">Overview</h2>';
	$d1 = get_field('description_1',$post->ID);
	$d2 = get_field('description_2',$post->ID);
	$d3 = get_field('description_3',$post->ID);
	$d4 = get_field('description_4',$post->ID);
	$yarn=get_field('yarn_type',$post->ID);
	$length= get_post_meta( $post->ID, '_length', TRUE );
	$width= get_post_meta( $post->ID, '_width', TRUE );
	$height= get_post_meta( $post->ID, '_height', TRUE );
	$weight= get_post_meta( $post->ID, '_weight', TRUE );
if(!empty($d1)){
	echo '<p>'.$d1.'</p>';
}
if(!empty($d2)){
	echo '<p>'.$d2.'</p>';
}
if(!empty($d3)){
	echo '<p>'.$d3.'</p>';
}
if(!empty($d4)){
echo '<p>'.$d4.'</p>';
}
		echo '<h3 class="detail-heading-item">SPECIFICATIONS</h3>';?>

		<ul class="specific-list">
		<?php if(!empty($yarn)){?>
		<li><span>YARN TYPE: </span><?php echo $yarn; ?></li><?php }?>
		<?php if(!empty($length) && !empty($width) && !empty($height)) {?>
		<li><span>SIZE: </span><?php echo $length.'cm x '.$width." ".$height;?> 
		</li>
		<?php }?>
		<?php if(!empty($weight)){?>
		<li><span>Weight: </span><?php echo $weight." kg"; ?> </li>
		<?php }?>
		</ul>
		<?php 
}?>
<?php 

add_action( 'cc_woocommerce_single_product_summary', 'cc_woocommerce_single_product_summary_function');
function cc_woocommerce_single_product_summary_function()
{


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action('woocommerce_single_product_summary', 'wc_oosm_display_outofstock_message', 6);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 10 );

 



}

add_action( 'cc_out_of_stock', 'cc_out_of_stock_function',100);
function cc_out_of_stock_function()
{
	add_action('woocommerce_single_product_summary', 'wc_oosm_display_outofstock_message', 6);
}
add_action( 'cc_woocommerce_single_product_summary_remove', 'cc_woocommerce_single_product_summary_remove_function');
function cc_woocommerce_single_product_summary_remove_function(){
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

}
add_action('cc_after_select_design_start','cc_after_select_design_function');
function cc_after_select_design_function(){
	add_action('woocommerce_single_product_summary', 'wc_oosm_display_outofstock_message', 10);
	
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );


}
add_action('cc_size_quantity','cc_size_quantity_function',40);
function cc_size_quantity_function(){

remove_action( 'woocommerce_single_product_summary', 'wc_oosm_display_outofstock_message', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );



add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}
function custom_quantity_field_archive() {
	$product = wc_get_product( get_the_ID() );
	if ( ! $product->is_sold_individually() && 'variable' != $product->product_type && $product->is_purchasable() ) {
		woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
	}
}
add_action( 'cc_custom_quantiy', 'custom_quantity_field_archive', 0, 9 );

// Place the following code in your theme's functions.php file
// override the quantity input with a dropdown
// Note that you still have to invoke this function like this:

add_action('cc_parent_product','smart_category_top_parent_id',10,1);
function smart_category_top_parent_id ($catid) {
    while ($catid) {
        $cat = get_category($catid); // get the object for the catid
        $catid = $cat->category_parent; // assign parent ID (if exists) to $catid
          // the while loop will continue whilst there is a $catid
          // when there is no longer a parent $catid will be NULL so we can assign our $catParent
        $catParent = $cat->cat_ID;
    }
    return $catParent;
}
/**
*to change the separator
*/
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_delimiter' );
function jk_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' &gt; ';
	return $defaults;
}
 //remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
function sv_change_product_price_display( $price ) {
	global $post;
	$pro = get_post_meta($post->ID);
	$price =  '<div class="cc-price-control">
	<h3><span class="cc-sale-price-title">A$'.$pro['_sale_price'][0].'</span> <span class="cc-line-through">$'.$pro['_regular_price'][0].'</span></h3></div>';

	return $price;
}
add_filter( 'woocommerce_get_price_html', 'sv_change_product_price_display' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 50;' ), 20 );
/**Modify the default WooCommerce orderby dropdown

/* Options: menu_order, popularity, rating, date, price, price-desc
/* In this example I'm removing price & price-desc but you can remove any of the options
*/
function patricks_woocommerce_catalog_orderby( $orderby ) {
	unset($orderby["rating"]);
	unset($orderby["date"]);
	unset($orderby["menu_order"]);
	$orderby['popularity']="Popularity";
	 $orderby['price'] ="Low to High";
    $orderby['price-desc'] = "High to Low";
//do_action('pr',$orderby);
	return $orderby;

	
}
add_filter( "woocommerce_catalog_orderby", "patricks_woocommerce_catalog_orderby", 20 );

