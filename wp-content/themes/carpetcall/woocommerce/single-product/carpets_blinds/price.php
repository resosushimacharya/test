<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
  <div class="cc-price-control">
    <h3><span itemprop="priceCurrency" content="AUD">$</span><span class="cc-sale-price-title" itemprop="price" content="<?php echo number_format(esc_attr( $product->get_price() ),2,'.',''); ?>"><?php echo number_format(esc_attr( round($product->get_price()) ),2,'.',''); ?></span><span class="low">/SQM</span> </h3>
  </div>
  <h3 class="online_price_subhead">ONLINE PRICE</h3>
  <meta itemprop="price" content="<?php echo esc_attr( round($product->get_price()) ); ?>" />
  <meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
  <?php /*?><link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" /><?php */?>
</div>
