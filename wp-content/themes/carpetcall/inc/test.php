<?php 


/*
+import_rugs_hard_schedule function  is hooked for csv import 
+ update_import_rugs_hard_hook and update_import_rugs_hard_function
+ for updating the products 
+ daily basis 
++ remove_import_rugs_hard_hook and remove_import_rugs_hard_function
++ for removing  the products 
++ weekly basis
*/

/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// Rugs file read ///////////////////////
/////////////////////////////////////////////////////////////////////////////////
function  cc_rugs_file_read($rfa){
$url = site_url();
		$url = explode('/',$url);
		$rugs_new_post_id=array();
		$rugs_old_post_id=array();
		 if(strcasecmp($url[2],'localhost')==0){
			$new_rugs_file = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/productfiles/'.$rfa;}
		else{
               $new_rugs_file = $_SERVER['DOCUMENT_ROOT'].'/productfiles/'.$rfa;
			}
			    if(file_exists($new_rugs_file)){
					$file_handle = fopen($new_rugs_file, 'r');
					$i=0;
					$line_of_text=array();
					
					while (!feof($file_handle) )
					 {
						 $csv= fgetcsv($file_handle, 0);
     						if(strcasecmp($csv[0],'state')!=0)
     						{
	                      		$csv_ids=csv_import_rugs($csv,"rugs");
								if($csv_ids['rugs_new_post_id'][0]){
									$rugs_new_post_id[]=$csv_ids['rugs_new_post_id'][0];
								}
								if($csv_ids['rugs_old_post_id'][0]){
									$rugs_old_post_id[]=$csv_ids['rugs_old_post_id'][0];
								}
                     		}
					 }
					fclose($file_handle);
				}
				else{
					echo "File doesn't exixt";
				}
	return  array(
		'rugs_new_post_id'=>$rugs_new_post_id,
		'rugs_old_post_id'=>$rugs_old_post_id,
		);
	
				
		}
/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// HArdfloor file read ///////////////////////
/////////////////////////////////////////////////////////////////////////////////		
		
function cc_hard_floor_file_read($hfa){
				$url = site_url();
		        $url = explode('/',$url);
				$hardfloor_old_post_id=array();
				$hardfloor_new_post_id=array();
            $mimes = array('application/vnd.ms-excel');	
            if(strcasecmp($url[2],'localhost')==0){
			   $new_rugs_file = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/productfiles/'.$hfa;}
		    else{
               $new_rugs_file = $_SERVER['DOCUMENT_ROOT'].'/productfiles/'.$hfa;
			}
			    if(file_exists($new_rugs_file)){
					$file_handle = fopen($new_rugs_file, 'r');
					$i=0;
					$line_of_text=array();
					
					
				
					while (!feof($file_handle) )
					 {
						 $csv= fgetcsv($file_handle, 0);
     						if(strcasecmp($csv[0],'Category')!=0)
     						{
	                      		$csv_ids=csv_import_hard_flooring($csv,"hard-flooring");
								if($csv_ids['hardfloor_old_post_id'][0]){
									$hardfloor_old_post_id[]=$csv_ids['hardfloor_old_post_id'][0];
								}
								if($csv_ids['hardfloor_new_post_id'][0]){
									$hardfloor_new_post_id[]=$csv_ids['hardfloor_new_post_id'][0];
								}
                     		}
					 }
					fclose($file_handle);
				}
				else{
					echo "File doesn't exixt";
				}
				
		return array(
			'hardfloor_old_post_id'=>$hardfloor_old_post_id,
			'hardfloor_new_post_id'=>$hardfloor_new_post_id
		);
}
       

if( ! ( function_exists( 'wp_get_attachment_by_post_name' ) ) ) {
    function wp_get_attachment_by_post_name( $post_name ) {
        $args = array(
            'post_per_page' => 1,
            'post_type'     => 'attachment',
            'name'          => trim ( $post_name ),
        );
        $get_posts = new Wp_Query( $args );

        if ( $get_posts->posts[0] )
            return $get_posts->posts[0]->ID;
        else
          return false;
    }
}

///////////////////////////////////////////////////////////////////////////
////////////////////////// cron fucntions ///////////////////////////////
////////////////////////////////////////////////////////////////////////
add_action( 'init', 'import_rugs_hard_schedule');
add_action('update_import_rugs_hard_hook','update_import_rugs_hard_function');
add_action('remove_import_rugs_hard_hook','remove_import_rugs_hard_function');
// Function which will register the event
function import_rugs_hard_schedule() {
	$zone = new DateTimeZone('Australia/Sydney'); // Or your own definition of "here"
      $todayStart = new DateTime('today midnight', $zone);
       $timestamp = $todayStart->getTimestamp();
	// Make sure this event hasn't been scheduled
	if( !wp_next_scheduled( 'update_import_rugs_hard_hook' ) ) {
		// Schedule the event
		wp_schedule_event($timestamp, 'daily', 'update_import_rugs_hard_hook' );
	}
	if( !wp_next_scheduled( 'remove_import_rugs_hard_hook' ) ) {
		
		// Schedule the event
		wp_schedule_event( $timestamp+60 , 'weekly', 'remove_import_rugs_hard_hook' );
	}
}
function update_import_rugs_hard_function(){
   cron_func_update();

}

function remove_import_rugs_hard_function(){
cron_func_delete();

}
////////////////////////////////////////////////////

function category_second_level($csvitem,$rootcatterm)
{
	$sluglower = strtolower($csvitem);
	$second_level_cat = array('name' => $csvitem,'description' => ' ','slug' =>$sluglower ,'parent'=>$rootcatterm);
	$parent = get_term_by('slug',$second_level_cat['parent'], 'product_cat');
	$cid = wp_insert_term(
	$second_level_cat['name'], // the term
	'product_cat', // the taxonomy
	array(
	'description'=> $second_level_cat['description'],
	'slug' => $second_level_cat['slug'],
	'parent' => $parent->term_id
	)
	); 
}
/*
 *checking whether to presence of third level category term in product_cat
  *it will add term if not present...
*/
function category_third_level($csvitem,$slct)
{
	$sluglower = strtolower($csvitem);
	$parentslug= strtolower($slct);
	$second_level_cat = array('name' => $csvitem,'description' => ' ','slug' =>$sluglower ,'parent'=>$parentslug);
	$parent = get_term_by('slug',$second_level_cat['parent'], 'product_cat');
	$cid = wp_insert_term(
	$second_level_cat['name'], // the term
	'product_cat', // the taxonomy
	array(
	'description'=> $second_level_cat['description'],
	'slug' => $second_level_cat['slug'],
	'parent' => $parent->term_id
	)
	); 
}


///////////////////////////////////////////////////////////////
/////////////// Import  rugs csv function/////////////////////
//////////////////////////////////////////////////////////////
/*
	* function to import Rugs products
	* will import products from uploaded CSV file
*/
function  csv_import_rugs($csv,$appcat)
{
	//set_time_limit(0) ;
	global $wpdb;
	
	$rugs_old_post_id=array();
	$rugs_new_post_id=array();

	$product_id = $wpdb->get_var($wpdb->prepare( "SELECT p.id FROM as_postmeta as m , as_posts as p WHERE m.meta_key='_sku' AND m.meta_value='%s' and p.post_status='publish' and p.Id=m.post_id LIMIT 1", $csv[1] ));
	if($product_id){
		$rugs_old_post_id[]=$product_id;
	}
	
	if($csv)
	{   
        $condimp = false;
		$query = array(
		    'post_type' => 'product',
		    'post_status' => array( 'pending') ,
		    'tax_query' => array(
		                            array(
		                                'taxonomy' => 'product_cat',
		                                'field'    => 'slug',
		                                'terms'    => $appcat
		                            )
		                        ),
			'meta_query' =>array(
		                            array(
		                                'key' => '_sku',
		                                'value'    => $csv[1],
		                            )
		                        ),
		);
		$loop_posts =get_posts($query );
		$count_post=count($loop_posts);
		if($count_post>0){
			$post_csv=$loop_posts[0];
			$skucomp = get_post_meta($post_csv->ID,'_sku',true);
		 		if(strcasecmp($skucomp,$csv[1])==0){
		              $temp = ltrim($csv[13], ' ');
		              $temp = rtrim($temp,' ') ;
		              $stockquantity = get_post_meta($post_csv->ID, '_stock',true);
		              $stockquantity = intval($stockquantity) + intval($temp);
		             update_post_meta($post_csv->ID, '_stock', $stockquantity);
		             $condimp = true;
		 		}
			
		};
			
		if(!$condimp){

		$post = array(
					 'post_title'   => $csv[1],
					 'post_status'  => "pending",
					 'post_name'    => sanitize_title($csv[1]), //name/slug
					 'post_type'    => "product",
					 'post_content' => $csv[4],
					 'post_excerpt' => $csv[4]
				     );
	 
		$rootcatterm = $appcat;		
		$new_post_id = wp_insert_post( $post );
		$rugs_new_post_id[]=$new_post_id;
		$slct        = $csv[3];
		$tlct        = $csv[2];
		if(!term_exists( $slct, 'product_cat', $rootcatterm ))
		{  
		   category_second_level($slct ,$rootcatterm) ;
		   category_third_level($tlct ,$slct);
		}
		elseif(!term_exists($tlct,'product_cat',$tlct ))
		{
		  category_third_level($tlct ,$slct);	
		}
		else{
			echo '<br/>'.ucfirst($rootcatterm).'>'.$slct.'>'.$tlct.'<br/>';
		}
		$main_cat = get_term_by( 'name', $slct, 'product_cat');
  
		$sub_cat  = get_term_by( 'name', $tlct, 'product_cat');
		$root_cat = get_term_by( 'name', ucfirst($rootcatterm), 'product_cat');
		
		
		$catarr=array($main_cat->slug,  $sub_cat->slug,$root_cat->slug);
		wp_set_object_terms( $new_post_id,$catarr, 'product_cat',true);
		//$transient_name = 'wc_product_children_ids_' . $new_post_id;
	//	delete_transient( $transient_name );					
		if($csv[13])
		{    $stockvar = intval($csv[13]);
	 		update_post_meta($new_post_id, '_stock_status', 'instock');
	        update_post_meta($new_post_id, '_stock', $stockvar);
	        update_post_meta($new_post_id, '_manage_stock', 'yes');
	    }
		$hhh = $csv[14];
		$hh=explode(' ',$hhh);
	    $length = str_replace("cm","","$hh[0]");
	    $width  =  str_replace("cm","","$hh[2]");
	    $height =  $hh[10];
	    $regular_price = str_replace(' ', '', $csv[16]);
	    $sale_price = str_replace(' ', '', $csv[18]);
	    $actual_price = str_replace(' ', '', $csv[18]);
		$regular_price = ltrim($regular_price, '0');
		$sale_price = ltrim($sale_price , '0');
		$actual_price = ltrim($actual_price, '0');
		$sku_arr = explode('.',$csv[1]);
		update_post_meta($new_post_id,'state',$csv[0]);
		update_post_meta( $new_post_id, '_sku', $csv[1]);
		$item_sku =  $csv[1];

		$sales_record_table = $wpdb->prefix.'cc_sales_records';
		$x = "SELECT * FROM ".$sales_record_table." WHERE sku = '".$item_sku."'";

		$exist =  $wpdb->get_row($x);
		if($item_sku){
		if(!$exist){
			$wpdb->insert( 
				$wpdb->prefix.'cc_sales_records', 
					array(
						'id'=>'', 
						'sku' =>$item_sku, 
						'sales_count' => 0 
					), 
					array( 
						'%d',
						'%s', 
						'%d' 
					) 
			);

		}
		}
		update_post_meta( $new_post_id, 'color', $sku_arr[2]);
		update_post_meta( $new_post_id, 'size_code', $sku_arr[3]);
		update_post_meta($new_post_id,'description_1',$csv[4]);
		update_post_meta($new_post_id,'description_2',$csv[5]);
		update_post_meta($new_post_id,'description_3',$csv[6]);
		update_post_meta($new_post_id,'description_4',$csv[7]);
		update_post_meta($new_post_id,'country_of_origin',$csv[8]);
		update_post_meta($new_post_id,'yarn_type',$csv[9]);
		update_post_meta($new_post_id,'construction',$csv[11]);
		update_post_meta($new_post_id,'care_instructions',$csv[12]);   
		update_post_meta( $new_post_id, '_weight', $csv[15] );
		update_post_meta( $new_post_id, '_regular_price', $regular_price  );
		update_post_meta( $new_post_id, '_sale_price', $sale_price );
		update_post_meta( $new_post_id, '_price', $actual_price );
		update_post_meta( $new_post_id, 'total_sales', 0);
		update_post_meta($new_post_id,'state',$csv[0]);
		update_post_meta( $new_post_id, '_visibility', 'visible' );
		update_post_meta( $new_post_id, '_length', $length);
		update_post_meta( $new_post_id, '_width', $width );
		update_post_meta( $new_post_id, '_height', $height);
		update_post_meta( $new_post_id, '_featured', 'no' );
	    update_post_meta($new_post_id,'discount',$csv[17]);
			$url= site_url().'/wp-content/uploads/products/';
				$img_arr=array(
						'life' => $csv[21].'.jpg',
						'side' => $csv[19].'.jpg',
						'swatch' => $csv[20].'.jpg'						
					);
   
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		//$tmp = download_url($life);


		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();
		//var_dump($wp_upload_dir);
		$file_loc= $wp_upload_dir['basedir'] ."/products/";
		$set_fea_img=false;
		$image_id=array();
		foreach($img_arr as $img){
				if(file_exists($file_loc.$img)){
		         $imgret = explode('.',$img);
		         $imgname = $imgret[0];  
						// Check the type of file. We'll use this as the 'post_mime_type'.
		                 $attachment_ID = wp_get_attachment_by_post_name($imgname );
		                 if($attachment_ID){
		                 	 $attach_id =$attachment_ID;
		                 	if(!$set_fea_img){
							set_post_thumbnail( $new_post_id, $attachment_ID );

						}
					      $set_fea_img=true;

		                 }
		                 else{
		                 	$filetype = wp_check_filetype( basename( $url.$img ), null );
						// Prepare an array of post data for the attachment.
						$attachment = array(
							'guid'           =>$url.$img, 
							'post_mime_type' => $filetype['type'],
							'post_title'     => preg_replace( '/\.[^.]+$/', '', $mgname  ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						);
						$attach_id = wp_insert_attachment( $attachment,$file_loc.$img, $new_post_id );
						// Generate the metadata for the attachment, and update the database record.
						$attach_data = wp_generate_attachment_metadata( $attach_id,  $file_loc.$img);
						wp_update_attachment_metadata( $attach_id, $attach_data );
						if(!$set_fea_img){
							set_post_thumbnail( $new_post_id, $attach_id );

						}
					      $set_fea_img=true;
		                 }
						// Insert the attachment.
						$image_id[]=$attach_id ;

			}

		}
		update_post_meta( $new_post_id, '_product_image_gallery', implode(",",$image_id));
		echo 'Rugs Product '.$csv[1].' imported</br>';
	}
}
	else  
	{
		if(isset($exist->ID))
		{
			echo $csv[1].'Rugs Item already exists';
		}
	}
	return  array(
		'rugs_new_post_id'=>$rugs_new_post_id,
		'rugs_old_post_id'=>$rugs_old_post_id,
		);
	

}


///////////////////////////////////////////////////////////////
/////////////// Import  Hardfloor csv function/////////////////////
//////////////////////////////////////////////////////////////
/*
	* function to import Hard Flooring products
	* will import products from uploaded CSV file
*/
	function  csv_import_hard_flooring($csv,$appcat)
{   
//	set_time_limit(0) ;
	global $wpdb;
	//$exist = get_page_by_title( $csv[1], OBJECT, 'product' );
	$hardfloor_old_post_id=array();
	$hardfloor_new_post_id=array();
	$product_id = $wpdb->get_var($wpdb->prepare( "SELECT p.id FROM as_postmeta as m , as_posts as p WHERE m.meta_key='_sku' AND m.meta_value='%s' and p.post_status='publish' and p.Id=m.post_id LIMIT 1", $csv[1] ));
	if($product_id){
		$hardfloor_old_post_id[]=$product_id;
	}
	if($csv)
	{   
        $condimp = false;
		$query = array(
		    'post_type' => 'product',
		    
		    'post_status' => array( 'pending') ,
		    'tax_query' => array(
		                            array(
		                                'taxonomy' => 'product_cat',
		                                'field'    => 'slug',
		                                'terms'    => $appcat
		                            )
		                        ),

		);
		$loop_posts =get_posts($query );
		$count_post=count($loop_posts);
		if($count_post>0){
			$post_csv=$loop_posts[0];
			 $skucomp = get_post_meta($post_csv->ID,'_sku',true);
		 	  
		 		if(strcasecmp($skucomp,$csv[1])==0){
		              $temp = ltrim($csv[2], ' ');
		              $temp = rtrim($csv[2],' ') ;
		              $stockquantity = get_post_meta($post_csv->ID, '_stock',true);
		              $stockquantity = intval($stockquantity) + intval($temp);
		             update_post_meta($post_csv->ID, '_stock', $stockquantity);
		             $condimp = true;
		 		}
			
		};

		if(!$condimp){

		$post = array(
					 'post_title'   => $csv[1],
					 'post_status'  => "pending",
					 'post_name'    => sanitize_title($csv[1]), //name/slug
					 'post_type'    => "product",
					 'post_content' => $csv[7],
					 'post_excerpt' => $csv[7]
				     );
	 
		$rootcatterm = $appcat;		
		$new_post_id = wp_insert_post( $post );
		$hardfloor_new_post_id[]=$new_post_id;
		$slct        = $csv[0];
		$tlct        = $csv[3];
		
		/*$rootcatterm  =  str_replace('_', ' ', $rootcatterm);
		$rootcatterm   = ucwords($rootcatterm);*/
		if(!term_exists( $slct, 'product_cat', $rootcatterm ))
		{  
		   category_second_level($slct ,$rootcatterm) ;
		   category_third_level($tlct ,$slct);
		}
		elseif(!term_exists($tlct,'product_cat',$tlct ))
		{
		  category_third_level($tlct ,$slct);	
		}
		else{
			echo '<br/>'.ucfirst($rootcatterm).'>'.$slct.'>'.$tlct.'<br/>';
		}
		$main_cat = get_term_by( 'name', $slct, 'product_cat');
  
		$sub_cat  = get_term_by( 'name', $tlct, 'product_cat');
		$root_cat = get_term_by( 'name',$rootcatterm , 'product_cat');
		
		
		
		$catarr=array($rootcatterm, $main_cat->slug,$sub_cat->slug);
		wp_set_object_terms( $new_post_id,$catarr, 'product_cat',true);
		//wp_set_object_terms( $new_post_id, $rootcatterm, 'product_cat',true);
		//wp_set_object_terms( $new_post_id, $main_cat->slug, 'product_cat',true);
		//wp_set_object_terms( $new_post_id, $sub_cat->slug, 'product_cat',true);
		//$transient_name = 'wc_product_children_ids_' . $new_post_id;
	//	delete_transient( $transient_name );	
					
		if($csv[2]){			
		      $stockvar = intval($csv[2]);
	 		update_post_meta($new_post_id, '_stock_status', 'instock');
	        update_post_meta($new_post_id, '_stock', $stockvar);
	        update_post_meta($new_post_id, '_manage_stock', 'yes');
	  
	}
		
	    $regular_price = (str_replace(' ', '', $csv[44]));

	     $regular_price =floatval(ltrim($regular_price, '0'));

	    
		update_post_meta( $new_post_id, '_sku', $csv[1]);
					$item_sku =  $csv[1];

		$sales_record_table = $wpdb->prefix.'cc_sales_records';
		$x = "SELECT * FROM ".$sales_record_table." WHERE sku = '".$item_sku."'";
		
			$exist =  $wpdb->get_row($x);
			if($item_sku){
			 if(!$exist){
			  $wpdb->insert( 
				 $wpdb->prefix.'cc_sales_records', 
				 array(
				  'id'=>'', 
				  'sku' =>$item_sku, 
				  'sales_count' => 0 
				 ), 
				 array( 
				  '%d',
				  '%s', 
				  '%d' 
				 ) 
				);
			  
			  }
			}
		
		update_post_meta($new_post_id,'description_1',$csv[7]);
		update_post_meta($new_post_id,'description_2',$csv[8]);
		update_post_meta($new_post_id,'description_3',$csv[9]);
		update_post_meta($new_post_id,'description_4',$csv[10]);
		update_post_meta($new_post_id,'country_of_origin_manufacture',$csv[11]);
		
	
		/*pack section */
		update_post_meta( $new_post_id, 'product_thickness_veneer', $csv[14] );
		update_post_meta( $new_post_id, 'pack_length', $csv[16] );
		update_post_meta( $new_post_id, 'pack_width', $csv[17] );
		update_post_meta( $new_post_id, 'pack_thickness', $csv[18] );
		update_post_meta( $new_post_id, 'pack_weight', $csv[19] );
		update_post_meta( $new_post_id, 'boards_per_pack', $csv[20] );
		update_post_meta( $new_post_id, 'size_m2', $csv[26] );
		
		/*end pack section */
       
		/* start option section */
		update_post_meta( $new_post_id, 'installation_options', $csv[21] );
		update_post_meta( $new_post_id, 'underlay_options', $csv[22] );
		update_post_meta( $new_post_id, 'glue_options', $csv[23] );
		update_post_meta( $new_post_id, 'scotia_options', $csv[24] );
		update_post_meta( $new_post_id, 'edge_type', $csv[27] );
		update_post_meta( $new_post_id, 'joint_type', $csv[28] );
		update_post_meta( $new_post_id, 'surface_finish', $csv[29] );
		update_post_meta( $new_post_id, 'janka_rating', $csv[30] );
        update_post_meta( $new_post_id, 'structural_warranty', $csv[31] );
        update_post_meta( $new_post_id, 'wear_layer_warranty', $csv[32] );
        update_post_meta( $new_post_id, 'construction_style', $csv[33] );
        update_post_meta( $new_post_id, 'recommended_use', $csv[34] );
        update_post_meta( $new_post_id, 'care_instructions', $csv[35] );
        update_post_meta( $new_post_id, 'coating', $csv[36] );
        update_post_meta( $new_post_id, 'ac_rating', $csv[37] );
        update_post_meta( $new_post_id, 'core_type', $csv[38] );
        update_post_meta( $new_post_id, 'anti_slip_test', $csv[39] );
        update_post_meta( $new_post_id, 'iso_certification', $csv[40] );
        update_post_meta( $new_post_id, 'base', $csv[41] );
        update_post_meta( $new_post_id, 'anti_slip_test', $csv[42] );
        update_post_meta( $new_post_id, 'trim_options', $csv[43] );
        update_post_meta( $new_post_id, 'discount', $csv[45] );
      
       
 
        	update_post_meta( $new_post_id, 'instructional_video',$csv[49]);
       
		/* end option section */

       /*    */
       $width  =  str_replace("mm","",$csv[13]);
       $length  = str_replace("mm","",$csv[12]);
       $thick = str_replace("mm","",$csv[15]);
		update_post_meta( $new_post_id, '_regular_price', $regular_price );
		update_post_meta( $new_post_id, '_sales_price', $regular_price );
		update_post_meta( $new_post_id, 'total_sales', 0);
		update_post_meta( $new_post_id, '_price', $regular_price );
		update_post_meta($new_post_id,'state',$csv[0]);
		update_post_meta( $new_post_id, '_visibility', 'visible' );
		update_post_meta( $new_post_id, '_length', $length);
		update_post_meta( $new_post_id, '_width', $width );
		update_post_meta( $new_post_id, '_height', $thick);
		update_post_meta( $new_post_id, 'product_thickness_veneer', $csv[14]);
		update_post_meta( $new_post_id, '_featured', 'no' );
	    update_post_meta($new_post_id,'discount',$csv[17]);
	
	  
			$url= site_url().'/wp-content/uploads/products/';
               

				$img_arr=array(
						'life' => $csv[47].'.jpg',
						'side' => $csv[46].'.jpg',
						'swatch' => $csv[48].'.jpg'						
					);
   
	
	
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		//$tmp = download_url($life);


		// Get the path to the upload directory.
$wp_upload_dir = wp_upload_dir();
//var_dump($wp_upload_dir);
$file_loc= $wp_upload_dir['basedir'] ."/products/";
$set_fea_img=false;
$image_id=array();
foreach($img_arr as $img){
		if(file_exists($file_loc.$img)){
         $imgret = explode('.',$img);
         $imgname = $imgret[0];  
				// Check the type of file. We'll use this as the 'post_mime_type'.
				

                 $attachment_ID = wp_get_attachment_by_post_name($imgname );
                 if($attachment_ID){
                 	 $attach_id =$attachment_ID;
                 	if(!$set_fea_img){
					set_post_thumbnail( $new_post_id, $attachment_ID );

				}
			      $set_fea_img=true;

                 }
                 else{
                 	$filetype = wp_check_filetype( basename( $url.$img ), null );
				// Prepare an array of post data for the attachment.
				$attachment = array(
					'guid'           =>$url.$img, 
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', $mgname  ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment,$file_loc.$img, $new_post_id );
				// Generate the metadata for the attachment, and update the database record.
				$attach_data = wp_generate_attachment_metadata( $attach_id,  $file_loc.$img);
				wp_update_attachment_metadata( $attach_id, $attach_data );
				if(!$set_fea_img){
					set_post_thumbnail( $new_post_id, $attach_id );

				}
			      $set_fea_img=true;
                 }
				// Insert the attachment.
				
				
				$image_id[]=$attach_id ;


	}

}
update_post_meta( $new_post_id, '_product_image_gallery', implode(",",$image_id));

		echo 'Hard Flooring Product '.$csv[1].' imported</br>';
	}
	}
	else  
	{
		if(isset($exist->ID))
		{
			echo $csv[1].'Hard Flooring Item already exists';
		}
	}
	return array(
		'hardfloor_old_post_id'=>$hardfloor_old_post_id,
		'hardfloor_new_post_id'=>$hardfloor_new_post_id
	)	;
}


/////////////////////////////////////////////////////////////////////////
/////////////////////////////Import Product Function //////////////////
////////////////////////////////////////////////////////////////////////

//add_action("admin_init",'cron_func_update');
function cron_func_update(){
	set_time_limit(0);
	    $url = site_url();
		$url = explode('/',$url);
		$countfileslen = 2;
		$counter=1;
		$rugfilesearray =array();
		$hardfloorfilesarray = array();
		$errorfilesarray = array();
		$errorflag = false;
		// to write a file and save in folder 
		 $time = current_time('mysql');
 
		if(strcasecmp($url[2],'localhost')==0){
			$desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/history/';}
		else{
               $desfolder= $_SERVER['DOCUMENT_ROOT'].'/history/';
			}
			  $time =  current_time('Y-m-d-m-h-s');
			$newfilename = $desfolder.'log'.$time.'.txt';
		
		

		 if(strcasecmp($url[2],'localhost')==0){
			$directory = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/productfiles';}
		else{
               $directory = $_SERVER['DOCUMENT_ROOT'].'/productfiles';
			}
		
	$csc_rugs_flag=$csc_hardfloor_flag=false;
	
	$rugs_post_ids= $hardfloor_ids=array();
		$filecols = array_diff(scandir($directory), array('..', '.'));
		foreach($filecols as $fileitem){
			if (strpos(strtolower($fileitem), 'rugols') !== false) {
				$fileextension = explode('.',$fileitem);
				if($fileextension[1]=='csv'){
					 	//$rugfilesearray[] = $fileitem ;
						   $rugs_post_ids[]=cc_rugs_file_read($fileitem );
						   $csc_rugs_flag=true;
				}
				else{
					echo "undefined file($fileitem) for rugs.";
				}
		
			}
			elseif(strpos(strtolower($fileitem), 'lols') !== false){
				$fileextension = explode('.',$fileitem);
				if($fileextension[1]=='csv'){
					 	//$hardfloorfilesarray[] = $fileitem;
						 $hardfloor_ids[]=cc_hard_floor_file_read( $fileitem);
						  $csc_hardfloor_flag=true;
				}
				else{
					echo "undefined file($fileitem) for hardflooring.";
				}
			}
			else{
				$errorfilesarray[] = $fileitem;
                 $errorflag = true;
			}
		}
		
				
		$rug_new_ids=$rug_old_ids=array();
		foreach($rugs_post_ids as $ids){
			$rug_new_ids=array_merge($rug_new_ids,$ids['rugs_new_post_id']);
			$rug_old_ids=array_merge($rug_old_ids,$ids['rugs_old_post_id']);
		}
		
		
		$hardfloor_new_ids=$hardfloor_old_ids=array();
		foreach($hardfloor_ids as $ids){
			$hardfloor_new_ids=array_merge($hardfloor_new_ids,$ids['hardfloor_new_post_id']);
			$hardfloor_old_ids=array_merge($hardfloor_old_ids,$ids['hardfloor_old_post_id']);
		}
		$old_product=array_merge($rug_old_ids,$hardfloor_old_ids);
		$new_product=array_merge($rug_new_ids,$hardfloor_new_ids);
		//////////////////////////////// //////////////////////
		////////////// Draft Product///////////////////////
		//////////////////// ////////////////////////////
		if(strcasecmp($url[2],'localhost')==0){
			$srcfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/productfiles/';
		    $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/history/';}
		else{
              $srcfolder= $_SERVER['DOCUMENT_ROOT'].'/productfiles/';
              $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/history/';
			}
         foreach($filecols as $bfa){ 
			 copy($srcfolder.$bfa, $desfolder.$bfa);
			 unlink($srcfolder.$bfa);
		 }
		 
		 $scv_arr=array();
		 if($csc_rugs_flag){
			 $scv_arr[]="rugs";
		 }
		 if($csc_hardfloor_flag){
			 $scv_arr[]="hard-flooring";
		 }
		 
		  wp_reset_query(); 
		global $wpdb;
		foreach($old_product as $id){
				$my_post = array(
				  'ID'           => $id,
				  'post_status'   => 'draft',
			  );
				// Update the post into the database
				 wp_update_post( $my_post );	
				
			}
			foreach($new_product as $id){
				$my_post = array(
				  'ID'           => $id,
				  'post_status'   => 'publish',
			  );
			  
				// Update the post into the database
				 wp_update_post( $my_post );	
				
			}
		 wp_reset_query(); 
		////////////////////////////////////////////////////
		$txt = "List of error files \r\n";
		if($errorflag){
		foreach($errorfilesarray as $efa){
			$txt .= $efa."\r\n" ;
		   }
	     } else{
           $txt .= "No error files ." ;
	     }
		 $myfile = fopen($newfilename, "w") or die("Unable to open file!");
		fwrite($myfile, $txt);
		fclose($myfile);
}

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////Delete Draft Product //////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//add_action('admin_init','cron_func_delete');
function cron_func_delete(){
$args = array(

				"post_type"=>'product',
				"post_status"=>array("draft"),
				"posts_per_page"=>"-1",
				'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => array('rugs','hard-flooring')
                                )
                            )
			);
		$loop = new WP_Query($args);

		$i  = 1;echo "Removed Product List : <br />";
		while($loop->have_posts()){
			$loop->the_post();
				wp_delete_post( $loop->post->ID, true ); 
		}
		wp_reset_query();


}