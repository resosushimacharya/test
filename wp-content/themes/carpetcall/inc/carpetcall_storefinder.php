<?php function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {


     $theta = $longitude1 - $longitude2;
     $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
     $distance = acos($distance);
     $distance = rad2deg($distance);
    
     $distance = $distance * 60 * 1.1515; switch($unit) {
          case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
     }
        
     return (round($distance,2));

}

add_filter('gd', 'getDistanceBetweenPointsNew' ,12, 5);
	function directory_autocomplete()
{

	global $wpdb;


	$keyword = $_POST['keyword'];
	$lat=$_POST['latitude'];
	$long=$_POST['longitude'];

  $prelat = $_POST['prelat'];
  $prelong = $_POST['prelong'];

$a=array();
$controlzip=1;?>

<?php

   $keyArray=explode(",",$keyword);
  
	
	$len=strlen($keyword);
	
	$fi==0;
	$li=0;
     $break=0;
     $myArrays= array();
	$backarg=array('post_type'=>'wpsl_stores',
    'posts_per_page'=>'-1'
		);


	$loop= new WP_Query(
		$backarg);
	while($loop->have_posts()):
	$loop->the_post();?>
    <?php $strpart=str_split(get_the_title(),$len);
    
  
   $loc = get_post_meta(get_the_ID());


      

    
    $latitude2=$loc['wpsl_lat'][0];
    	$longitude2=$loc['wpsl_lng'][0];
  ?>
 
       <?PHP if($controlzip==1){?>

       <div class="loctitle" >STORES NEAR :&nbsp; <?php echo $keyArray[0]; ?> </div>  
       <?php $controlzip++; }?>
       
         
        <?php if(!empty($lat)){?>

       <?php 
        $latlongloc = getDistanceBetweenPointsNew($lat, $long, $latitude2, $longitude2,'Km');
          
        $myArrays[]=array($loc['wpsl_address'][0],$loc['wpsl_city'][0],$loc['wpsl_state'][0],$loc['wpsl_zip'][0],$latlongloc,get_the_title()); ?>
        <?php }
        else{?>
         <?php
          $latlongloc = getDistanceBetweenPointsNew($prelat, $prelong, $latitude2, $longitude2,'Km');



      $myArrays[]=array($loc['wpsl_address'][0],$loc['wpsl_city'][0],$loc['wpsl_state'][0],$loc['wpsl_zip'][0],$latlongloc,get_the_title()); 
         }?>         
              

 
 <?php  
 
	endwhile;



   ?>
	<?php function sortByOrder($a, $b) {
    return $a[4] - $b[4];
}

usort($myArrays, 'sortByOrder');

?>
  
	    <?php  if(count($myArrays)!=0):?>
	    <?php $zloop=1; if($lat):?>
	<?php foreach($myArrays as $ma):?>
		<?php if($zloop==4){

			break;
			} 
			$zloop++;?>
		
           <div class="col-md-8">

                            <address>
                              <strong><u><?php echo $ma[5];?>:</u></strong><br>
                               <?php echo $ma[0].' '.$ma[1].' '.$ma[2].' '.$ma[3] ;
                               ?>
                              
                            </address>
                            </div> 
                            <div class="col-md-4"><p><strong><?php
                             echo $ma[4].' km'; 
                       ?> 
                            </strong></p></div><div class="clearfix"></div>
	<?php endforeach;?>

<?php else:?>
	<?php foreach($myArrays as $ma):?>
		<?php if($zloop==4){

      break;
      } 
      $zloop++;

      ?>
		

           <div class="col-md-8">

                             <address>
                              <strong><u><?php echo $ma[5];?>:</u></strong><br>
                               <?php echo $ma[0].' '.$ma[1].' '.$ma[2].' '.$ma[3] ;
                               ?>
                              
                            </address>
                            </div> 
                            <div class="col-md-4"><p><strong><?php
                             echo $ma[4].' km'; 
                       ?> 
                            </strong></p></div><div class="clearfix"></div>
	<?php endforeach;?>
<?php endif;
else:?>
    
           <div class="col-md-8">

                            <address>
                              
                               <?php echo "no stores found" ;
                              echo  count($myarrays);?>
                               
                              
                            </address>
                            </div><div class="clearfix"></div>
  <?php endif;?>
	<div class="morepl"><a href="#"> See more nearby stores </a></div>
   
	<?php die();
	wp_reset_query();
}
add_action('wp_ajax_dir_autocmp', 'directory_autocomplete');
add_action('wp_ajax_nopriv_dir_autocmp', 'directory_autocomplete');
function test_scripts(){
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');
	wp_register_script('autocomplete', get_template_directory_uri(). '/js/store.autocomplete.js', '',true);

wp_enqueue_script('autocomplete');
wp_localize_script( 'autocomplete', 'wp_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}
add_action( 'wp_enqueue_scripts', 'test_scripts' );

function  directory_autocomplete_store()
{
global $wpdb;
	//print_r($wpdb);
	$keyword = $_POST['keyword'];
	$lat=$_POST['latitude'];
	$long=$_POST['longitude'];
	

	
	/*$ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$url = "http://freegeoip.net/json/$ip";
$ch  = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
$data = curl_exec($ch);
curl_close($ch);*/


    
	 
	$len=strlen($keyword);
	
	$fi==0;
	$conDis=1;
	$li=1;
	$html="";
$tax="wpsl_store_category";

	if(!empty($_POST['keyword'])){?>
	<?php $backarg=array('post_type'=>'wpsl_stores'
    
    );
$mn = 1 ;
	$loop= new WP_Query(
		$backarg);
	while($loop->have_posts()):
	$loop->the_post();?>
    <?php
   $tax_terms=get_the_terms(get_the_ID(),'wpsl_store_category');

     $mn++;
       foreach ($tax_terms  as $tax_term) {
          if(strcmp($tax_term->slug=="center")==0){
       // do_action('pr',$tax_terms);
     $break++; 
          
     $loc=get_post_meta(get_the_ID());

    
     $strpart=str_split(get_the_title(),$len);
    $strzip = str_split($loc['wpsl_zip'][0],$len);
    $strstate = str_split($loc['wpsl_state'][0],$len);
    $strcity = str_split($loc['wpsl_city'][0],$len);
     

      $locdisplayy =array();
    $x=strcmp($strpart[0],$keyword);
    if($fi==2)
    {
    	$latitude1=$loc['wpsl_lat'][0];

    	$longitude1=$loc['wpsl_lng'][0];
    }
    $latitude2=$loc['wpsl_lat'][0];
    	$longitude2=$loc['wpsl_lng'][0];

     $fi++;


         

       
        
       ?>
        
<?php
if((strcasecmp($strzip[0],$keyword)==0)){?>
 
   <?php 
        
        $html.= '<a onclick="set_store(\''.str_replace("-", ",", $loc['wpsl_zip'][0]).'\')">'.$loc['wpsl_zip'][0].'</a>';
  
      
         $sto=$loc['wpsl_zip'][0];
        
      ?>
       
  <?php  
  $li++;}
  if((strcasecmp($strcity[0],$keyword)==0)){?>

   <?php 
         

        $html.= '<li onclick="set_store(\''.str_replace("-", ",",$loc['wpsl_city'][0]).'\')">'.$loc['wpsl_city'][0].'</li>';
       
        $sto=$loc['wpsl_city'][0];
        
      ?>
       
  <?php  
  $li++;}



  ?>
                            
       
<?php
/*if((strcasecmp($strzip[0],$keyword)==0) || (strcasecmp($strstate[0],$keyword)==0)  || (strcasecmp($strcity[0],$keyword)==0) ){?>

   <?php 
	
        $html.= '<li onclick="set_store(\''.str_replace("-", ",", $loc['wpsl_zip'][0].'-'.$loc['wpsl_city'][0].',' .$loc['wpsl_state'][0] ).'\')">'.$loc['wpsl_zip'][0].'-'.$loc['wpsl_city'][0].',' .$loc['wpsl_state'][0]  .'</li>';
        
      ?>
       
  <?php  
  $li++;}*/


  ?>
    


	<?php
	$conDis++;}}
	endwhile;
	wp_reset_query();
	}
	echo  $html;
  die();

}
add_action('wp_ajax_dir_store', 'directory_autocomplete_store');
add_action('wp_ajax_nopriv_dir_store', 'directory_autocomplete_store');
function store_scripts(){
	//wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		//wp_enqueue_script('jquery');
	wp_register_script('store_autocomplete', get_template_directory_uri(). '/js/state.finder.js', '',true);

wp_enqueue_script('store_autocomplete');
wp_localize_script( 'store_autocomplete', 'wp_autocomplete_store', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}
add_action( 'wp_enqueue_scripts', 'store_scripts' );


/* CARPET CALL WOOCOMERCE AJAX CALL */
function woocommerce_minicart_cc(){


  ?>

<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><div class="mcrt">
      <img src="<?php echo get_template_directory_uri() ;?>/images/cart-icon.png" alt="icon" width="31" height="25" style="float:left;"/> <span class="crrt"> MY CART </span>
      <div class="rnkct"> <span class="badge" id="count" >
        <?php $count=0;
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
        $count++;
        endforeach;
        echo $count; ?>
      </span>
    </div>
  </div> </a>
  

  <ul class="dropdown-menu">
    <li><span class="mycrt_blk">my cart (<?php echo  $count; ?>)</span></li>
    <?php //do_action('pr',WC()->cart->get_cart());?>
    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
      $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
          $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {?>
    <li>
      <div class="crtblk_sec">
        <div class="crt_pname">
          
          <h2><ins><?php $reqTempTerms=get_the_terms($product_id ,'product_cat');
          
          foreach($reqTempTerms as $reqTerm){
            if($reqTerm->term_id!=20)
            {
              echo $reqTerm->name;
              break;
            }
          } ?>- <?php if ( ! $_product->is_visible() ) {
          echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
          } else {
          echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
          }?></ins></h2>
          <h3> <?php
          echo $cart_item['quantity'];
          
          ?> x <span class="rugcl"><?php
            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
          ?></span> </h3>
        </div>
        
        
        <div class="crt_price">
          <h4><?php
          echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );?> </h4>
        </div>
        </div><div class="clearfix"></div>
      </li>
      
      <?php }
      }?>
      <li>
        <div class="crtblk_sec">
          <div class="crt_pname">
            <h5> TOTAL</h5>
            
          </div>
          
          
          <div class="crt_price">
            <h4><?php echo WC()->cart->get_cart_total(); ?></h4>
          </div>
          </div><div class="clearfix"></div>
        </li>
        
        <li>
          <div class="crt_clear">
            <div class="view_c view_cc">
              <a href="<?php echo get_permalink(33);?>"> VIEW CART </a>
            </div>
            
            <div class="check_crt check_crtt">
              <a href="<?php echo get_permalink(34);?>"> CHECKOUT </a>
              </div><div class="clearfix"></div>
              </div><div class="clearfix"></div>
            </li>
            
          </ul>
        
          

<?php die(); } 
add_action('wp_ajax_woocommerce_cc', 'woocommerce_minicart_cc');
add_action('wp_ajax_nopriv_woocommerce_cc', 'woocommerce_minicart_cc');
