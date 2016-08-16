<?php 
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
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
	
	global $product;
	$post = $product;
	$top_cat = '';
	$reqTempTerms=get_the_terms($post->ID,'product_cat');
                   
                 
                if($reqTempTerms){
                   foreach($reqTempTerms as $cat){
                   	  
                   		if($cat->parent==0){
                   			
                   			if(strcasecmp($cat->slug, 'rugs')==0){
                   				$top_cat = 'rugs';
                   			}
                   		
                   	
                   			if(strcasecmp($cat->slug, 'hard-flooring')==0){
                   				$top_cat = 'hard-flooring';
                   			}
                   		
                   		}
                   	}
               	}
				
				
				
	
	// Adds the new tab

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
	$tabs['additional_information']['title'] = __( 'DETAILS' );	// Rename the additional information tab
	$tabs['additional_information']['callback'] = 'woo_custom_information_tab_content';
	
	$tabs['faq_tab'] = array(
		'title' 	=> __( "FAQ'S", 'woocommerce' ),
		'priority' 	=> 49,
		'callback' 	=> 'woo_new_product_tab_content'
	);
	
	$tabs['ret_tab'] = array(
		'title' 	=> __( 'RETURNS', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content_ret'
	);

if($top_cat == 'hard-flooring'){
	$tabs['accesories_tab'] = array(
		'title' 	=> __( "ACCESSORIES", 'woocommerce' ),
		'priority' 	=> 1,
		'callback' 	=> 'woo_new_product_tab_accesories'
	);
	$tabs['specifications_tab'] = array(
		'title' 	=> __( "SPECIFICATIONS", 'woocommerce' ),
		'priority' 	=> 46,
		'callback' 	=> 'woo_new_product_tab_specifications'
	);
	$tabs['guides_tab'] = array(
		'title' 	=> __( "GUIDES", 'woocommerce' ),
		'priority' 	=> 47,
		'callback' 	=> 'woo_new_product_tab_guides'
	);
	}else{
		$tabs['care_tab'] = array(
		'title' 	=> __( 'CARE INSTRUCTIONS', 'woocommerce' ),
		'priority' 	=> 48,
		'callback' 	=> 'woo_new_product_tab_content_care'
	);
	}
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
      

     <div class="cont-panl  cc-pro-det-fb hf-products">
			
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
            <div class="panel-group" id="accordion_<?php echo $faqcounter;?> ">
					      
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle <?php echo ($faqcounter==1)?'':'collapsed' ;?> " data-toggle="collapse" data-parent="#accordion_<?php echo $faqcounter;?> " href="#collapse_<?php echo $faqcounter;?>">
            <span class="pull-right glyphicon glyphicon glyphicon-chevron-down " ></span>	
			<span class="pull-right glyphicon glyphicon-chevron-up"></span>

          <?php echo $listitem['title'];?>
        </a>
      </h4>
    </div>
    <div id="collapse_<?php echo $faqcounter;?>" class="panel-collapse collapse <?php echo ($faqcounter==1)?'in':'' ;?> ">
      <div class="panel-body panel-body-faq">
      
        <p><?php echo $listitem['description']?></p>
      
      </div>
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
					
               
					
				</div>
  <div class="cc-tab-faq-read-more">
  	<p>For more answers to your questions, please refer to our <a href="<?php echo get_the_permalink($faqid ); ?>"><?php echo $rootname; ?> FAQ </a> page.</p>
  </div>
<?php	
}
function woo_new_product_tab_accesories() {
	global $product;
	$current_loaded_product = $product;
	$accessory_term_obj = get_term_by('slug','accessories','product_cat');
	$acc_cats = get_terms(
					'product_cat',
					array(
						'parent' => $accessory_term_obj->term_id,
						'hide_empty'=>false,
					)
				);

	//$acc_cats = get_term_children( $accessory_term_obj->term_id, 'product_cat' );
	//do_action('pr',$acc_cats);
	if(!empty($acc_cats)){?>
    <div class="cont-panl cc-pro-det-fb">
            
     <?php
	 $count = 1;
		foreach($acc_cats as $acc_cat){?>
		         <div class="panel-group" id="accordion_<?php echo $count;?>">
            	<div class="panel panel-default">
                    <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle <?php echo ($count==1)?'first-acc-cat':'collapsed' ;?> " data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $acc_cat->term_id;?>">
               <span class="pull-right glyphicon glyphicon glyphicon-chevron-down " ></span>	
			<span class="pull-right glyphicon glyphicon-chevron-up"></span>
                <?php echo $acc_cat->name;?>
                </a>
            </h4>
        </div>
                    <div id="collapse_<?php echo $acc_cat->term_id;?>" class="panel-collapse collapse <?php echo ($count==1)?'in':'' ;?> ">
                    <div class="panel-body panel-body-faq hf-faq">
                    <?php
						$acc_products = get_posts(
											array(
												'posts_per_page' => -1,
												'post_type' => 'product',
												'tax_query' => array(
													array(
														'taxonomy' => 'product_cat',
														'field' => 'term_id',
														'terms' => $acc_cat->term_id,
													)
												)
											)
										);
					//do_action('pr',$acc_products);
					global $post;
					$parent = $post;
					if(!empty($acc_products)){
						wp_reset_postdata();
						foreach($acc_products as $acc_product){
							global $post,$product;
							$product  = wc_get_product($acc_product->ID);
							$post = get_post($acc_product);
							setup_postdata($post);
							?>
							<div class="acc_list_item col-md-3 <?php echo $acc_cat->slug?>">
								<div class="accessories_innner_wrap">
                                    <div class="acc_info_wrap" data-toggle="modal" data-target="#accinfo_<?php echo get_the_ID()?>_<?php echo $acc_cat->slug;?>">
                                    <div class="acc_thumb">
                                        <?php if(has_post_thumbnail($acc_product->ID)){
											echo get_the_post_thumbnail($acc_product->ID,'thumbnail');
										}else{
											echo '<img width="150" height="150" src="'.get_template_directory_uri().'/images/placeholder.png">';
											}?>
                                    </div>
                                    <h3 class="acc_title_n_cat">
                                    <span class="acc_title"><a href="javascript:void(0)"><?php _e($acc_product->post_title,'carpetcall');?></a></span> 
                                    <span class="acc_subcat">
                                    <?php 
                                    $categories = get_the_terms($acc_product->ID, 'product_cat' ); 
                                    // wrapper to hide any errors from top level categories or products without category
                                    if ( $categories ) : 
                                        // loop through each cat
                                        foreach($categories as $category) :
                                        
                                          // get the children (if any) of the current cat
                                          $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));
                                          if ( count($children) == 0 ) {
                                              // if no children, then echo the category name.
                                              echo '<a href="javascript:void(0)">'.$category->name.'</a>';
                                              break;
                                          }
                                        endforeach;
                                    
                                    endif;
                                    
                                    ?>
                                    
                                    </span>
                                    </h3>
                                   
                                    <span class="acc_price small_price">
                                        <?php echo $product->get_price_html();?>
                                    </span>
                                    </div>
                                    <div class="acc_qnty">
                                    <?php 
                                    if($acc_cat->slug == 'underlay'){
                                    $tpm_ratio = get_field('tpm_ratio',get_the_ID())?get_field('tpm_ratio',get_the_ID()):1;	
                                    $rec_qty = ceil(get_field('size_m2',$current_loaded_product->id)/(get_field('tpm_ratio',get_the_ID())?get_field('tpm_ratio',get_the_ID()):1));
                                    
                                    }else{
                                        $rec_qty='';}?>
                                        <div class="rec_qty_wrap"><span class="acc_qty_lbl"><?php echo ($rec_qty=='')?'':'Rec'?> Qty: </span> 
                                        <span class="acc_rec_qty" tpm_ratio="<?php echo $tpm_ratio?>"><?php echo $rec_qty?></span></div><?php
                                        echo woocommerce_quantity_input( array( 'min_value' => 0, 'max_value' => $product->backorders_allowed() ? '' : max(20,$product->get_stock_quantity())) );
                                        ?>
                                    </div>
                                    <?php $x=do_shortcode('[add_to_cart_url id="'.$acc_product->ID.'"]');?>
                                    <a href="<?php echo $x ;?>" data-quantity="1" data-product_id="<?php echo $acc_product->ID;?>" class="button product_type_simple col-md-12 acc_add_to_cart" >ADD TO CART</a>
                                    <div class="modal fade" tabindex="-1" role="dialog" id="accinfo_<?php echo get_the_ID()?>_<?php echo $acc_cat->slug;?>">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <span aria-hidden="true" class="close" data-dismiss="modal">&times;</span>
                                    <h4 class="modal-title"><?php the_title()?></h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php the_content();?>
                                    </div>
                                    </div>
                                    </div>
                                </div>
								</div>
                            </div>
                            
                            <?php 
							wp_reset_postdata();
							}?>
                            	 
                            <?php
						}
					
					
					?>
                    
                            
                            
                    </div>
                    </div>
   </div>
        </div>
			
			<?php
			$count++;
            }
			?>
         
    </div>
		<?php
		}
	
	
	?>
<?php	
}
function woo_new_product_tab_guides(){
	global $post;
	$installation_guide = get_field('installation_options');
	$maintainance_guide = get_field('care_instructions');
	?>
    <div class="cont-panl">
        <div class="panel-group" id="accordion_guides">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_guides" href="#collapse_installtion_guide">
                    <span class="pull-right glyphicon glyphicon-chevron-up"></span>
                    <?php _e('INSTALLATION GUIDE','carpetcall')?>
                    </a>
                </h4>
            </div>
            <div id="collapse_installtion_guide" class="panel-collapse collapse in">
                <div class="panel-body panel-body-faq">
                	<p><?php echo $installation_guide;?></p>
                </div>
            </div>
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_guides" href="#collapse_maintainance_guide">
                    <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                    <?php _e('MAINTAINANCE GUIDE','carpetcall')?>
                    </a>
                </h4>
            </div>
            <div id="collapse_maintainance_guide" class="panel-collapse collapse">
                <div class="panel-body panel-body-faq">
                	<p><?php echo $maintainance_guide;?></p>
                </div>
            </div>
        </div>
        </div>
    </div>
	<?php
	}
function woo_new_product_tab_specifications(){
	wp_reset_postdata();
	global $post,$product;
	echo '<h3 class="detail-heading-item-spec">Product Specifications</h3>';?>
	<table class="product_specifications_table">
    	<tr>
            <td class="spec_label"><?php _e('Country of Origin Manufacture','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('country_of_origin_manufacture')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Colour','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('species__colour_decore')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Price per pack','carptecall')?></td>
            <td class="specs_value"><?php echo $product->get_price();?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Boards per pack','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('boards_per_pack')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Coverage per pack','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('size_m2')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Product - Length','carptecall')?></td>
            <td class="specs_value"><?php echo get_post_meta( $post->ID, '_length', TRUE );?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Product - Width','carptecall')?></td>
            <td class="specs_value"><?php echo $width= get_post_meta( $post->ID, '_width', TRUE );?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Product - Thickness Veneer','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('product_thickness_veneer')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Product - Thickness Total','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_thickness')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Pack - Length','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_length')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Pack - Width','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_width')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Pack - Weight','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_weight')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Underlay Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('underlay_options')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Board Type','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('board_type')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Supplier','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('supplier')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Installation options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('installation_options')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Underlay Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('species_colour_decore')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Glue Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('glue_options')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Scotia Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('scotia_options')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Accessories','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('accessories')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Edge Type','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('edge_type')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Joint System','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('joint_system')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Surface Finish','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('surface_finish')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Janka Rating','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('janka_rating')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Structural Warranty','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('structural_warranty')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Wear Layer Warranty','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('wear_layer_warranty')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Construction Style','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('construction_style')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Recommended Use','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('species__colour_decore')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Recommended Areas of Use','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('recommended_use')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Standards - Coating','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('coating')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Standards - AC Rating','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('ac_rating')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Standards - Core Type','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('core_type')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Standards - Anti Slip Test','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('anti_slip_test')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Standards - Base','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('base')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('ISO Certification','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('iso_certification')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Trim Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('trim_options')?></td>
        </tr>
    	<tr>
            <td class="spec_label"><?php _e('Instructional Video','carptecall')?></td>
            <td class="specs_value">
			<?php 
			if(get_field('instructional_video')){
				echo get_field('instructional_video');
				//echo wp_video_shortcode(array('src'=> get_field('instructional_video')));
			}?>
			
            </td>
        </tr>
    </table>
    <?php 
	//$fields = get_fields($post->ID);
	//do_action('pr',$fields);
	?>
    
    <?php
	}
/*
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
	$tabs['additional_information']['title'] = __( 'DETAILS' );	// Rename the additional information tab

	return $tabs;

}
*/
/*
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

*/
function woo_new_product_tab_content_care() {?>
<?php global $product;
global $post;
$careins = get_field('care_instructions',$post->ID);
if(!empty($careins)){
	echo '<p>'.$careins.'</p>';
}
?>

<?php }?><?php 

/*
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
*/
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
echo '<p class="returns_text">'.$retinfo.'</p>';

?>

<?php }?><?php 
/*
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {
	$tabs['additional_information']['priority'] = 5;			// Reviews first
	$tabs['care_tab']['priority'] = 10;			// Description second
	$tabs['faq_tab']['priority'] = 15;
	$tabs['ret_tab']['priority'] = 20; 	// Additional information third

	return $tabs;
}
*/
/*
add_filter( 'woocommerce_product_tabs', 'woo_custom_information_tab', 98 );
function woo_custom_information_tab( $tabs ) {

	$tabs['additional_information']['callback'] = 'woo_custom_information_tab_content';	// Custom description callback

	return $tabs;
}
*/
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
		echo '<h3 class="detail-heading-item-spec">SPECIFICATIONS</h3>';?>
		<ul class="specific-list">
		<?php if(!empty($yarn)){?>
		<li><span>Yarn Type : </span><?php echo $yarn; ?></li><?php }?>
		<?php if(!empty($length) && !empty($width) && !empty($height)) {?>
		<li><span>Size : </span><?php echo $length.'cm x '.$width." ".$height;?> 
		</li>
		<?php }?>
		<?php if(!empty($weight)){?>
		<li><span>Weight : </span><?php echo $weight." kg"; ?> </li>
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
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 10 );
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
	if (array_key_exists("_sale_price",$pro) && $pro['_sale_price'][0]!=''){
		$prosale = 'A$'.$pro['_sale_price'][0];
		$price =  '<div class="cc-price-control">
	<h3><span class="cc-sale-price-title">'.$prosale.'</span> <span class="cc-line-through">A$'.$pro['_regular_price'][0].'</span></h3></div>';
	}
	else{
		$prosale = $prosale = 'A$'.$pro['_regular_price'][0];
		$price =  '<div class="cc-price-control">

	<h3><span class="cc-sale-price-title">'.$prosale.'</span> </h3></div>';
	}

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

add_filter( 'woocommerce_product_bundle', 'woocommerce_product_bundle_action', 10, 1);
function woocommerce_product_bundle_action($results){
	
	$data = array();
	$i =0 ;

	foreach($results as $key => $value){

	                   $length= get_post_meta( $key, '_length', TRUE );
                       $width= get_post_meta( $key, '_width', TRUE );
                       $height= get_post_meta( $key, '_height', TRUE );
                       $price = get_post_meta($key,'_sale_price',TRUE);
                       $productsize   = $length.'CM X '. $width.'CM - $'.$price;  
                       $data[$i] =array($productsize,get_the_permalink($key),$key,$price);

                       $i++;
	}
	
	function sortByOrder($a, $b) {
    
    	return $a[3] - $b[3];
   	}

  usort($data, 'sortByOrder');
	return $data;

}
 /**
 * List best selling products on sale
 *
 * @access public
 * @param array $atts
 * @return string
 */
function woocommerce_best_selling_products( $atts ){
    global $woocommerce_loop;
    extract( shortcode_atts( array(
        'per_page'      => '12',
        'columns'       => '4',
        'category'		=> 'amore'
        ), $atts ) );
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts'   => 1,
        'posts_per_page' => $per_page,
        'meta_key'     => 'total_sales',
      'orderby'      => 'meta_value',
        'meta_query' => array(
            array(
                'key' => '_visibility',
                'value' => array( 'catalog', 'visible' ),
                'compare' => 'IN'
            )
        ),
       'tax_query' => array(
	    	array(
		    	'taxonomy' => 'product_cat',
				'terms' => array( esc_attr($category) ),
				'field' => 'slug',
				'compare' => 'IN'
			)
	    )

    );
    ob_start();
    
  $products = new WP_Query( $args );
  
  $woocommerce_loop['columns'] = $columns;
  if ( $products->have_posts() ) : ?>

    <ul class="products">

      <?php while ( $products->have_posts() ) : $products->the_post(); ?>

        <?php woocommerce_get_template_part( 'content', 'product' ); ?>

      <?php endwhile; // end of the loop. ?>

    </ul>

  <?php endif;
  wp_reset_postdata();
  return ob_get_clean();
}
add_shortcode('best_selling_products', 'woocommerce_best_selling_products');


