<?php get_header(); ?>
<div class="child-innerpg">
    <div class="container clearfix">
        <div class="inerblock_serc_child about-page">
            <div class="cc-breadcrumb">
              <span class="cc-bread-current"><?php 
			  if(is_cart()){
				  echo 'Shopping Cart';
				  }elseif(is_checkout()){
					  
					  }else{
					  the_title();
					} ?></span>
            </div><!-- end .cc-breadcrumb -->
            <h1><?php the_title(); ?></h1>
            <?php if(is_cart() || is_checkout()){?>
				<div class="cart_checkout_header_subtitle clearfix">
<p><?php _e("We've set this stock aside for 30mins to ensure you don't miss out","carpetcall");?></p>
<?php if(is_cart()){?>
<p class="return-to-shop">
	<a class="button wc-backward" href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) );?>">
		<?php _e('Continue Shopping','carpetcall')?>	</a>
</p>
<?php }?>
</div>
				<?php }?>
        </div><!-- end .innerblock_serc_child -->
    </div><!-- end .container.clearfix -->
</div><!-- end .child-innerpg -->

<div class="faq-cont-blka">
    <div class="container clearfix">
        <div class="inerblock_sec cc-page-all">
            

            <div class="col-md-12 no-lr cc-terms-condn">
                <div class="cbg_content cc-condn-page">
                    <?php 
                        the_content();
                    ?>
                </div><!-- end .cbg_content -->
            </div><!-- end .col-md-9 -->

        </div><!--end .innerblock_sec -->
    </div><!-- end .container.clearfix -->
</div><!-- end .faq-cont-blka -->

<?php get_footer(); ?>