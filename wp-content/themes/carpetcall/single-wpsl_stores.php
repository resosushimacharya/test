<?php  /*$x= $_SERVER['HTTP_REFERER'];*/

get_header();?>
<?php 
global $post;

$state_post_parent = $post->post_parent;
$cat_names = wp_get_post_terms($post->ID, 'wpsl_store_category', array("fields" => "names"));
$cat_name = $cat_names[0];


?>
<?php 

$statename = "";
$regions = array(
'QLD' => 'Queensland',
'NSW' =>'New South Wales',
'SA' =>'South Australia',
'TAS'=>'Tasmania',
'VIC'=>'Victoria',
'WA'=>'Western Australia',
'ACT'=>'Australia Capital Territory',
'NT'=>'Northern Territory'
);
foreach($regions as $key =>$value):
	if(strcasecmp($key,$cat_name)==0){
		$statename = strtoupper($value); 
	
	}

endforeach;

if(array_key_exists('HTTP_REFERER',$_SERVER)){
	$backurl=$_SERVER['HTTP_REFERER'];
}
else{
	$backurl=site_url().'/find-a-store/'.strtolower($cat_name);
}
$backurl=site_url().'/find-a-store/'.strtolower($cat_name);
?>

<div class="container clearfix">
    <div class="inerblock_serc_cde cc-locator-sec">
        <div class="cc-locator-title-sec-z">
			<?php 
            echo '<h4><span class="cc-locator-sub"><a href="'.site_url().'/find-a-store/">'. 'STORE FINDER'.'</a></span>'.'>'.'<span class="cc-locator-root"><a href="'.site_url().'/find-a-store/'.strtolower($cat_name).'">'. $statename .'</a></span>'.'>'.'
            <span class="cc-locator-current"><a href="'.get_the_permalink().'">'. strtoupper(get_the_title()).'</a></span></h4>';
            
            ?>
        
        </div>
        <div class="col-md-12 clearfix single-store-top-cntr">
        
            <div class="col-md-6 view-all-link mobile">
			<a href="<?php echo $backurl?>">
            	<span class="fa fa-angle-left"></span> VIEW ALL STORES
            </a>
            </div>
            
            
            <?php 
            $url = site_url();
            $url =explode('/',$url);
            
            $stateID ="";
            if(strcasecmp($url[2],'localhost')==0){
            $stateID = '1770';       
            }
            else{
            $stateID ='26771';
            }
            ?>
            <div class="col-md-6 single-store-title">
            	<h3><?php echo get_the_title();?></h3>
            </div>
            
            <div class="col-md-6 view-all-link desktop">
            	<a href="<?php echo $backurl?>">< VIEW ALL STORES</a>
            </div>
        
        </div>
        <div class="cc-ad-map-strn col-md-12 clearfix">
            <div class="col-md-5 wpsl-single-left">
                <div class="cc-info-store clearfix">
                    <div itemscope itemtype="http://schema.org/LocalBusiness" class="single-store-top-info">
                        <div class="wpsl-address-sec">
                        <h4>ADDRESS</h4>
                        <?php 
                        $getinfo = get_post_meta($post->ID);
                        $title = get_the_title();
                        $address_full = explode(',',$getinfo['wpsl_address'][0]);
                        $street = $address_full[1];
                        $locality = $address_full[0];
                        $city = $getinfo['wpsl_city'][0];
                        $postcode = $getinfo['wpsl_zip'][0];
                        $phone = $getinfo['wpsl_phone'][0];
                        $fax = $getinfo['wpsl_fax'][0];
                        ?>
                        
                        
                        <h1><span itemprop="name"><?php echo get_the_title()?></span></h1>
                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="single-store-bottom-info">
                        <?php if($street){?>
                        <span itemprop="streetAddress"><?php echo $street?></span><br>
                        <?php } ?>
                        <?php if($locality){?> 
						<span itemprop="addressLocality"><?php echo $locality?></span>,
						<?php }?>
                        <?php if($city){?><span itemprop="addressRegion"><?php echo $city?></span><br><?php }?>
                      
                        <?php if($postcode){?>
                        <span itemprop="postalCode"><?php echo $postcode?></span>
                        <?php } ?>
                        </div>
                        <?php
                        /*
                        echo do_shortcode('[wpsl_address id="'.$post->ID.'" name="true" address="true" address2="false" 
                        city="true" state="false" zip="true" country="false" phone="false" title="false"
                        fax="false" email="false" url="true"]');
                        */
                        ?>
                        <?php $url = get_post_meta($post->ID);
                        $val = "res";
                        $res =  apply_filters('cc_current_location_filter',$val);
                        global $post;
                        
                        $phone = ' -';
                        $fax = '-';
                        
                        if(array_key_exists('wpsl_phone',$getinfo)){
                        $phone = $getinfo['wpsl_phone'][0];
                        $x= $phone;
                        
                        $x = preg_replace('/\s+/', '', $x);
                        $x = '+61'.$x; 
                        $phone = '<a href="tel:'.$x.'"> '.$phone.'</a>'; 
                        }
                        if(array_key_exists('wpsl_fax',$getinfo)){
                        $fax = $getinfo['wpsl_fax'][0];
                        }
                        ?>
                        
                        <a href="https://maps.google.com/maps?saddr=<?php echo $res;?>&daddr=<?php echo $url['wpsl_address'][0].' '.$url['wpsl_city'][0];?>" target="_blank">GET DIRECTIONS</a>
                        </div>
                        <div class="wpsl-phone-sec cc-single-wpsl-ccstore">
                        <div class="cc-storef-phnum"><?php if(array_key_exists('wpsl_phone',$getinfo)){ ?>
                        <strong>Phone:  </strong><span class="cc-cat-store-item-phone" itemprop="telephone"> <?php echo $phone ;?></span>
                        <?php } ?></div>
                        <div class="cc-storef-phnum"><?php if(array_key_exists('wpsl_fax',$getinfo)){?>
                        <strong>Fax: </strong><span class="cc-cat-store-item-fax" itemprop="faxNumber"> <?php echo $fax ;?></span>  
                        <?php  } ?></div>
                        
                        
                        <div class="cc-str-cntblk cc-str-cntblk-a cc-str-cntblk-a-map clearfix">
                        <a href="<?php echo site_url();?>/contact-us/?id=<?php echo $post->ID;?>" class="cc-contact-link">CONTACT STORE</a>
                        </div>
                        </div>
                    </div>
                </div>
                <div id="wpsl-result-list"><div id="wpsl-stores"><ul class="test">
                </ul>
                </div>
                
                </div>
                <div class="wpsl-hour-sec clearfix">
                    <span><strong>Opening Hours</strong></span>
                    <?php $wpsl_store = new WPSL_Frontend();
					$hours = $getinfo['wpsl_hours'][0];
                    $hide_closed = apply_filters( 'wpsl_hide_closed_hours', false );
                    $hours = maybe_unserialize( $hours );
                    $opening_days = wpsl_get_weekdays();
                    if ( $wpsl_store->not_always_closed( $hours ) ) {
						foreach ( $opening_days as $index => $day ) {
							$i          = 0;
							$hour_count = count( $hours[$index] );
							if ( $hide_closed && !$hour_count ) {
								continue;
							}
							?>
							<div itemprop="openingHoursSpecification" itemtype="http://schema.org/OpeningHoursSpecification" class="opeaning_list">
							<link itemprop="dayOfWeek" href="http://schema.org/<?php echo esc_html( ucfirst($day) )?>" /><span class="opeaning_day_label"><?php echo esc_html( $day )?></span>: 
							
							
							
							<?php
							if ( $hour_count > 0 ) {
							while ( $i < $hour_count ) {
								$hour        = explode( ',', $hours[$index][$i] ); ?>
									<time class="opeaning_day_time" itemprop="opens" content="<?php echo esc_html( $hour[0] )?>"> <?php echo esc_html( $hour[0] )?></time> - <time class="opeaning_day_time" itemprop="closes" content="<?php echo esc_html( $hour[1] )?>"><?php echo esc_html( $hour[1] ) ?></time>
								<?php  
								$i++;
							}
							} else {
								echo 'closed';
							}?>
                            </div>
                            <?php
						}
                    }
                    ?>
                    </div>
            </div>
            <div class="col-md-7 wpsl-single-right clearfix">
                
                <?php echo do_shortcode('[wpsl_map id="'.$post->ID.'" width="500" height="350" zoom="5" map_type="roadmap" 
                map_type_control="true" map_style="custom" street_view="false" 
                scrollwheel="true" control_position="left"]'); 
                ?>
                </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<style>
.cc-wrapper-blk{
background:#f0f2f1 !important;
}
.cc-wrapper-whole h3{
text-decoration:none !important;
border:none;

}
.cc-contact-side{

}
.cc-form-wrapper{
padding:5px;}
#wpsl-stores{
overflow:visible !important;
}
.fcnt-orr-map a {
background:#fff;
border:1px solid #1858b8;
color:#1858b8;
} 
.fcnt-orr-map a:hover{
background:#fff;
}

</style>
<?php
get_footer();
?>