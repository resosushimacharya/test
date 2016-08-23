<?php
global $woocommerce, $product;


?>
<div class="delivery_option_rugs">
<?php get_template_part( 'templates/delivery/pickup_closest', 'office' );?>

<?php do_action( 'woocommerce_checkout_shipping' ); ?>
</div>