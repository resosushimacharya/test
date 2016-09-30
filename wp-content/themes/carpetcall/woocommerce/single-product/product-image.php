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
					   echo '<h1 class="cc-category-show"><span itemprop="name">'.$cat->name.' - '.$parent_term->name.'</span></h1>';
					  }else{
					   $parent_term = $cat;
					   echo '<h1 class="cc-category-show"><span itemprop="name">'.$cat->name.'</span></h1>';
					  }
                
              	}
              	}
              	}
				
				$feat_image = get_template_directory_uri().'/images/placeholder.png';
				if((has_term('carpets','product_cat',get_the_ID())) || (has_term('blinds','product_cat',get_the_ID())) || (has_term('awnings','product_cat',get_the_ID())) || (has_term('shutters','product_cat',get_the_ID()))){
					$attachment_ids = $product->get_gallery_attachment_ids();
					//do_action('pr',$attachment_ids);
					foreach( $attachment_ids as $attachment_id ) 
					{
						$image_link = wp_get_attachment_url( $attachment_id );
						$feat_image_obj = wp_get_attachment_image_src($attachment_id,'full');
						$feat_image = $feat_image_obj[0];
						break;
						?>
					
					<?php
					}
			
			
						
		}else{
				$feat_image = cc_custom_get_feat_img(get_the_ID(),'large');
				$sku = explode('.',get_post_meta($post->ID,'_sku',true));
				/*
				$sku = explode('.',get_post_meta($post->ID,'_sku',true));
				$image_names = array(
								strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_L.jpg',
								strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_V.jpg',
								strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_S.jpg',
							);
							
					foreach($image_names as $imgname){
						$img_path =  WP_CONTENT_DIR.'/uploads/images/large/'.$imgname;
						if(file_exists($img_path)){
						$feat_image = content_url('uploads/images/large/'.$imgname);
						break;
					}
				}
				*/
				}
				
				?>
                
                <div class="main-image-wrapper">
                <a href="<?php echo $feat_image?>" 
                itemprop="image" 
                class="woocommerce-main-image zoom" 
                title="<?php echo strtoupper( $post->post_name )?>">
                <img 
                width="560" 
                height="373" 
                itemprop="image" 
                src="<?php echo $feat_image?>" 
                class="attachment-full size-full wp-post-image" alt="<?php echo strtoupper( $post->post_name )?>" 
                title="<?php echo strtoupper( $post->post_name )?>" 
                srcset="<?php echo $feat_image?>" 
                sizes="(max-width: 560px) 100vw, 560px">
                </a>
                <div class="main-image-over-wrapper">
                <img src="<?php echo get_template_directory_uri()?>/images/magnify1.png" 
                class="main-image-over">
                </div>
                </div>
                
                
                
	<?php
	/*
	$imgurl =get_template_directory_uri().'/images/magnify1.png';
		if ( has_post_thumbnail() ) {
			$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
			$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'full' ), array(
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
			echo '<div class="no-product-image">';
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
			echo '</div>';

		}
	
	*/?>

	<?php //do_action( 'woocommerce_product_thumbnails' ); ?>
   
    <div class="cc_custom_gal_thumb thumbnails columns-3">
    
    <?php
		
			echo '<div class="product_single_thumb_slider">';
			
	
	?>
    	<?php 
		if((has_term('carpets','product_cat',get_the_ID())) || (has_term('blinds','product_cat',get_the_ID())) || (has_term('awnings','product_cat',get_the_ID())) || (has_term('shutters','product_cat',get_the_ID()))){
		$attachment_ids = $product->get_gallery_attachment_ids();
		
		foreach( $attachment_ids as $attachment_id ) 
		{
			$image_link = wp_get_attachment_url( $attachment_id );
			$image_thumb = wp_get_attachment_image_src($attachment_id,'thumbnail');
			?>
        <div class="single-thumb-img">
        <a href="<?php echo  $image_link?>" class="single-product-thumb-img">
        
        	
        	<img src="<?php echo $image_thumb[0]?>">
            
            
        </a></div>
		<?php
        }

			
						
		}else{
		if(has_term('rugs','product_cat',get_the_ID())){
			$image_names = array(
								strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_L.jpg',
								strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_V.jpg',
								strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_S.jpg',
							);
			}
		if(has_term('hard-flooring','product_cat',get_the_ID())){
			$image_names = array(
								strtoupper($sku[0]).'_L.jpg',
								strtoupper($sku[0]).'_V.jpg',
								strtoupper($sku[0]).'_S.jpg',
							);
			}	
		//$sku = explode('.',get_post_meta(get_the_ID(),'_sku',true));
		
		$feat_image = $feat_image_full = get_template_directory_uri().'/images/placeholder.png';
		foreach($image_names as $imgname){
			$img_path =  WP_CONTENT_DIR.'/uploads/images/large/'.$imgname;
			$thumb_path =  WP_CONTENT_DIR.'/uploads/images/medium/'.$imgname;
			if(file_exists($img_path)){
				$feat_image_full = content_url('uploads/images/large/'.$imgname);
				if(file_exists($thumb_path)){
					$feat_image = content_url('uploads/images/medium/'.$imgname);
				} ?>
				<div class="single-thumb-img">
        <a href="<?php echo  $feat_image_full ?>" class="single-product-thumb-img">
        	<img src="<?php echo $feat_image?>">
        </a></div>
		<?php

			}
		}
			
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
    <?php
		
			echo '</div>';
			
	
	?>
    </div>
    
		<div class="mod-social clearfix">
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
<script type="text/javascript">
jQuery(document).ready(function() {
	/* Act on the event */


});
	

</script>
