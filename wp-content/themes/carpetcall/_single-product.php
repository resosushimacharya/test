<?php
/*
* Template Name: 
*/?><?php get_header();?>
<style>
ul.cc-item-image-group{
	list-style: none;
}
</style>

<div class="container clearfix">
	<div class="inerblock_serc">
	
		<?php 
		global $product;
			while(have_posts()):?>
			<div class="col-md-8">
			<?php 
			the_post();
		    the_title();
			the_content();
			$data = get_post_meta($post->ID);
			echo
			the_post_thumbnail();
			do_action('pr',$data);
			
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			?>
			</div>
            <div class="col-md-4">
           <?php  do_action( 'woocommerce_single_product_summary' ); ?>
            	<div class="cc-item-price-section">
			 		<div class="cc-pro-price-sale pull-left">
			 			<h2><?php echo "A$".$data['_sale_price'][0];?></h2>
			 		</div>
			 		<div class="cc-pro-price-regular pull-right">
			 			<?php echo "A$".$data['_regular_price'][0];?>
			 		</div>
			 		<div class="clearfix"></div>
		    		<div class="cc-item-title">
		    			<h2>ONLINE PRICE</h2>
		    			<?php echo "CODE:".$data['_sku'][0];?>
		    		</div>
		    	</div>
		    	<div class="cc-items-design-section">
		    	<h4>SELECT  A DESIGN </h4>
		    	 <div class="cc-item-image-group-section">
		    	 <?php do_action( 'woocommerce_after_single_product_summary' );
		    	echo   do_shortcode("[add_to_cart id={$post->ID}]");?>
		    	 	<ul class="cc-item-image-group">
		    	 	<?php for($z=0;$z<=10;$z++){?>
		    	 		<li class="col-md-3 cc-item-image">
                         <img src="<?php echo $feat_image;?>"/>
		    	 		</li>
		    	 		<?php }?>
		    	 	</ul>
		    	 </div>
		    	</div>
		    	<div class="clearfix"></div>
		    	<div class="cc-item-size-section">
		    	<h4>Available Sizes</h4>
		    	 <div class="cc-item-image-group-section">
		    	 	<select class="selectpicker">
  						<option>Mustard</option>
  						<option>Ketchup</option>
  						<option>Relish</option>
					</select>

		    	 </div>
		    	</div>

		    </div>
			<?php 
			endwhile;
		?>	
		
		
		 </div>
</div>
		<?php 
   			global  $product;

				$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?><div class="container clearfix">
	<div class="thumbnails col-md-12 <?php echo 'columns-' . $columns; ?>"><?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop === 0 || $loop % $columns === 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns === 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image_title 	= esc_attr( get_the_title( $attachment_id ) );
			$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );

			$image_class = esc_attr( implode( ' ', $classes ) );
            ?>
            <div class="col-md-2"><?php
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );
            ?>
            </div>
            <?php
			$loop++;
		}

	?></div>
	</div>
	<?php
}
?>
   
<div class="clearfix"></div>
<div class="container clearfix">
 
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">DETAILS</a></li>
    <li><a data-toggle="tab" href="#menu1">CARE INSTRUCTIONS</a></li>
    <li><a data-toggle="tab" href="#menu2">FAQ'S</a></li>
    <li><a data-toggle="tab" href="#menu3">RETURNS</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active ">
      <h3>DETAILS</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
     <div class="panel-group" id="accordion">
      <?php for($faqcounter=1;$faqcounter<=4;$faqcounter++){?>
      <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $faqcounter;?>">
          <span class="pull-right glyphicon <?php echo ($faqcounter==1)?'glyphicon-chevron-up':'glyphicon glyphicon-chevron-down'?>"></span>
         <?php echo "FAQ".$faqcounter;?>
        </a>
      </h4>
    </div>
    <div id="collapse_<?php echo $faqcounter;?>" class="panel-collapse collapse <?php echo ($faqcounter==1)?'in':'' ;?> ">
      <div class="panel-body">
        <?php echo "FAQ".$faqcounter."content" ;?>
      </div>
    </div>
  </div><?php }?>
  </div>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h2>RETURNS</h2>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>

<?php get_footer();?>