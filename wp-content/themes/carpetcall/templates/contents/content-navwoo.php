<ul class="nav navbar-nav navbar-right" id="mywoosection">
      	<li class="dropdown woocomerce_dropdown" id="woo_control" >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="mcrt">
                             <img src="<?php echo get_template_directory_uri() ;?>/images/cart-icon.svg" alt="icon" width="31" height="25" style="float:left;"/>
                             <span class="crrt"> MY CART </span>
                             <div class="rnkct">
                                 <span class="badge" id="counttest" >
                                  <?php 
								  global $woocommerce;
                                          $count=0;
                                          foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
                                                  $count++;
                                          endforeach;
                                          echo $count; 
                                  ?>

                                  </span>

                              </div>
                        </div> 
                </a>
                <ul class="dropdown-menu" id="cc-mini-cart-cntr"></ul>
	     </li>
</ul>
