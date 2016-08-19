<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>
<div class="images">
    <?php 
     $reqTempTerms=get_the_terms($post->ID,'product_cat');

   
            if($reqTempTerms){
           foreach($reqTempTerms as $cat){
           	$has_sub_cat=get_terms(array('parent'=>$cat->term_id,'taxonomy'=>'product_cat'));
              if(count($has_sub_cat)==0){
                  if( $cat->parent != 0){
					   $parent_term = get_term( $cat->parent, 'product_cat');
					   echo '<h4 class="cc-category-show">'.$cat->name.' - '.$parent_term->name.'</h4>';
					  }else{
					   $parent_term = $cat;
					   echo '<h4 class="cc-category-show">'.$cat->name.'</h4>';
					  }
                
              	}
              	}
              	}?>
	<?php
	$imgurl =get_template_directory_uri().'/images/magnify1.png';
		if ( has_post_thumbnail() ) {
			$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
			$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> get_the_title( get_post_thumbnail_id() )
			) );

			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="main-image-wrapper"><a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a><div class="main-image-over-wrapper"><img src="%s" class="main-image-over" /></div></div>', $image_link, $image_caption, $image,$imgurl ), $post->ID );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

		}
	?>

	<?php //do_action( 'woocommerce_product_thumbnails' ); ?>
   
    <div class="cc_custom_gal_thumb thumbnails columns-3">
    	<?php 
		 $attachment_ids = $product->get_gallery_attachment_ids();
		
		foreach( $attachment_ids as $attachment_id ) 
		{
			$image_link = wp_get_attachment_url( $attachment_id );
			$image_thumb = wp_get_attachment_image_src($attachment_id,array('150','150'));
			?>
        <a href="<?php echo  $image_link?>">
        	<img src="<?php echo $image_thumb[0]?>">
        </a>
		<?php
        }


		//do_action('pr',get_post_meta(get_the_ID()));
		/*
		$thumbs =get_post_meta(get_the_ID(),'_product_image_gallery');
		if(!empty($thumbs)){
			$thumbs = explode(',',$thumbs[0]);
			foreach($thumbs as $thumb){
				$thumb_url = wp_get_attachment_image_src($thumb,'shop_thumbnail');
				$thumb_full_url = wp_get_attachment_image_src($thumb,'full');
				?>
                <a href="<?php echo $thumb_full_url[0]?>">
                	<img class="attachment-shop_thumbnail size-shop_thumbnail" src="<?php echo $thumb_url[0]?>">
                </a>
                <?php
				}
			} 
			*/
			?>
    
    </div>
    
		<div class="mod-social">
		<div class="cc-share-title">SHARE: </div>
		<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($post->ID);?>" target="_blank">
          <i class="fa fa-2x fa-facebook-square" aria-hidden="true"></i>
         </a>
         <a href="https://twitter.com/share?url=<?php echo get_the_permalink($post->ID);?> " target="_blank">      
         <i class="fa fa-2x  fa-twitter" aria-hidden="true"></i>
         </a>
<a href="#" onclick="window.open('https://www.pinterest.com/pin/create/bookmarklet/?url=<?php echo get_the_permalink($post->ID); ?>')">
          <i class="fa fa-2x fa-pinterest" aria-hidden="true"></i>
           </a>



         </div>
</div>
