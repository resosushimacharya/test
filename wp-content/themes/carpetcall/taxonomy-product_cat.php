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
<?php
	$current_cat = get_term_by('slug',get_query_var('product_cat'),'product_cat');
	$ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );
	$depth = count($ancestors) ; 
	if($depth >= 2 ){
		//We will only have template for depth level 0 and 1, third level category won't be listed here
		return ;
		}

$top_cat = smart_category_top_parent_id($current_cat->term_id,'product_cat');
if($top_cat){
	$top_cat_obj = get_term_by('id',$top_cat,'product_cat');
	$top_cat_slug = $top_cat_obj->slug;
	if($top_cat_slug == 'rugs' || $top_cat_slug == 'hard-flooring'){
		get_template_part('templates/category',$top_cat_slug);
	}else if($top_cat_slug == 'carpets' || $top_cat_slug == 'blinds'){
		//get_template_part('templates/category','carpet_n_blinds');
		}
}
?>


<?php get_footer();?>
