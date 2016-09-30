<?php get_header(); ?>
<div class="child-innerpg">
    <div class="container clearfix">
        <div class="inerblock_serc_child about-page">
            <div class="cc-breadcrumb">
              <span class="cc-bread-current"><?php 
			  if(is_cart()){
				  echo 'Shopping Cart';
				  }elseif(is_checkout()){?>
					  <?php  if(is_checkout() && ! empty( $wp->query_vars['order-received'] )){
            ?>
           <?php  the_title(); ?>
            <?php }?>
					 <?php }else{
					  the_title();
					} ?></span>
            </div><!-- end .cc-breadcrumb -->
          <?php  if(is_checkout() && ! empty( $wp->query_vars['order-received'] )){
			 $order_id = get_query_var('ORDER-RECEIVED');
			$_order = new WC_Order($order_id);
            ?>
            
            <h1><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Your order has been received', 'woocommerce' ), $_order ); ?></h1>
         <?php } else{ ?>
            <h1><?php the_title(); ?></h1>
            <?php  }?>
            <?php if(is_cart() || is_checkout()){?>
				<div class="cart_checkout_header_subtitle clearfix">
<?php /*?><p><?php _e("We've set this stock aside for 30mins to ensure you don't miss out","carpetcall");?></p><?php */?>
<?php if(is_cart()){?>
<p class="return-to-shop">
	<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
		<?php _e( 'Continue Shopping', 'woocommerce' ) ?>
	</a>
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