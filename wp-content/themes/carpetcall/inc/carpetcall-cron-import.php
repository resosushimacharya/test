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

add_action( 'init', 'import_rugs_hard_schedule');
add_action('update_import_rugs_hard_hook','update_import_rugs_hard_function');
add_action('remove_import_rugs_hard_hook','remove_import_rugs_hard_function');
// Function which will register the event
function import_rugs_hard_schedule() {
	// Make sure this event hasn't been scheduled
	if( !wp_next_scheduled( 'update_import_rugs_hard_hook' ) ) {
		// Schedule the event
		wp_schedule_event( time()+MINUTE_IN_SECONDS, 'daily', 'update_import_rugs_hard_hook' );
	}
	if( !wp_next_scheduled( 'remove_import_rugs_hard_hook' ) ) {
		// Schedule the event
		wp_schedule_event( time()+2, 'daily', 'remove_import_rugs_hard_hook' );
	}
}
function update_import_rugs_hard_function(){
   cron_func_update();

}





function remove_import_rugs_hard_function(){
cron_func_delete();

}

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
/*
 *To read CSV FILE
  *it will store the result in array and return the array
*/
function readCSV($csvFile)
{
	$file_handle = fopen($csvFile, 'r');
	$i=0;

 	while (!feof($file_handle) )
 	 {
		$line_of_text[] = fgetcsv($file_handle, 0);
 	 }
 	fclose($file_handle);
 	return $line_of_text;
}

/*
	* function to import Rugs products
	* will import products from uploaded CSV file
*/
function  csv_import_rugs($csv,$appcat)
{
	set_time_limit(0) ;
	$exist = get_page_by_title( $csv[1], OBJECT, 'product' );

	if($csv)
	{
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
		wp_set_object_terms( $new_post_id, $main_cat->slug, 'product_cat',true);
		wp_set_object_terms( $new_post_id, $sub_cat->slug, 'product_cat',true);
		wp_set_object_terms( $new_post_id, $root_cat->slug, 'product_cat',true);

							
			
		$transient_name = 'wc_product_children_ids_' . $new_post_id;
		delete_transient( $transient_name );					
					
		if($csv[13]!=0)
		{
	 		update_post_meta($new_post_id, '_stock_status', 'instock');
	        update_post_meta($new_post_id, '_stock', $csv[13]);
	        update_post_meta($new_post_id, '_manage_stock', 'yes');
	    }
	    else
	    {
	        update_post_meta($new_post_id, '_stock_status', 'outofstock');
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

				// Check the type of file. We'll use this as the 'post_mime_type'.
				$filetype = wp_check_filetype( basename( $url.$img ), null );
				// Prepare an array of post data for the attachment.
				$attachment = array(
					'guid'           =>$url.$img, 
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', $csv[19] ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				// Insert the attachment.
				$attach_id = wp_insert_attachment( $attachment,$file_loc.$img, $new_post_id );
				// Generate the metadata for the attachment, and update the database record.
				$attach_data = wp_generate_attachment_metadata( $attach_id,  $file_loc.$img);
				wp_update_attachment_metadata( $attach_id, $attach_data );
				if(!$set_fea_img){
					set_post_thumbnail( $new_post_id, $attach_id );
				}
				$set_fea_img=true;
				$image_id[]=$attach_id ;

	}

}
update_post_meta( $new_post_id, '_product_image_gallery', implode(",",$image_id));


		echo 'Rugs Product '.$csv[1].' imported</br>';

	}
	else  
	{
		if(isset($exist->ID))
		{
			echo $csv[1].'Rugs Item already exists';
		}
	}
}
/*
	* function to import Hard Flooring products
	* will import products from uploaded CSV file
*/
	function  csv_import_hard_flooring($csv,$appcat)
{   
	set_time_limit(0) ;
	$exist = get_page_by_title( $csv[1], OBJECT, 'product' );

	if($csv)
	{
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
		wp_set_object_terms( $new_post_id, $rootcatterm, 'product_cat',true);
		wp_set_object_terms( $new_post_id, $main_cat->slug, 'product_cat',true);
		wp_set_object_terms( $new_post_id, $sub_cat->slug, 'product_cat',true);
		

							
			
		$transient_name = 'wc_product_children_ids_' . $new_post_id;
		delete_transient( $transient_name );					
					
		if($csv[2]!=0)
		{
	 		update_post_meta($new_post_id, '_stock_status', 'instock');
	        update_post_meta($new_post_id, '_stock', $csv[2]);
	        update_post_meta($new_post_id, '_manage_stock', 'yes');
	    }
	    else
	    {
	        update_post_meta($new_post_id, '_stock_status', 'outofstock');
	    }
		
	    $regular_price = str_replace(' ', '', $csv[44]);
	  
	  
	     
	    

	     $regular_price = ltrim($regular_price, '0');
	
	

	   
	   
	  	
		
	    
		update_post_meta( $new_post_id, '_sku', $csv[1]);
		
		
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

				// Check the type of file. We'll use this as the 'post_mime_type'.
				$filetype = wp_check_filetype( basename( $url.$img ), null );
				// Prepare an array of post data for the attachment.
				$attachment = array(
					'guid'           =>$url.$img, 
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', $csv[19] ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				// Insert the attachment.
				$attach_id = wp_insert_attachment( $attachment,$file_loc.$img, $new_post_id );
				$thumbid = media_handle_sideload( $new_post_id, basename($file_loc.$img) );
				// Generate the metadata for the attachment, and update the database record.
				$attach_data = wp_generate_attachment_metadata( $attach_id,  $file_loc.$img);
				wp_update_attachment_metadata( $attach_id, $attach_data );
				if(!$set_fea_img){
					set_post_thumbnail( $new_post_id, $thumbid );
				}
				$set_fea_img=true;
				$image_id[]=$attach_id ;

	}

}
update_post_meta( $new_post_id, '_product_image_gallery', implode(",",$image_id));

		echo 'Hard Flooring Product '.$csv[1].' imported</br>';
	}
	else  
	{
		if(isset($exist->ID))
		{
			echo $csv[1].'Hard Flooring Item already exists';
		}
	}
}

function cron_func_update(){
  $countfileslen = 2;
	       $counter=1;
    for($counter=1;$counter<=3;$counter++){

	if($counter==1){
			$new_rugs_file = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/csvfolder/rugs.csv';
		   $appcat = "rugs";
			echo $new_rugs_file;
				
			    if(file_exists($new_rugs_file)){
					
					$csvs = readCSV($new_rugs_file);
					
				
					
				
					if($csvs)
					{
						$args = array(
						             'taxonomy'     => 'product_cat',
							         'hide_empty'               => 0,
						         );
						$cats = array();
						  
						$procats = get_categories( $args );
						foreach ($procats as $cat)
						{
							 $cats[$cat->name][0] = (int) $cat->term_id;
						}
						global $wpdb;
						$i =0;
                       
						foreach($csvs as $csv)
						{

                         
     						if(strcasecmp($csv[0],'state')!=0)
     						{
	                      		csv_import_rugs($csv,$appcat);

                     		}
		
		
						}



					} 
					else
					{
						echo 'Sorry file can\'t be uploaded';
					}
				}
				else{
					echo "File doesn't exixt";
				}
		

		
	}
	elseif($counter==2){
$mimes = array('application/vnd.ms-excel');	
		$new_rugs_file = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/csvfolder/hard-flooring.csv';
		     $appcats = "hard-flooring";
			echo $new_rugs_file;
				
			    if(file_exists($new_rugs_file)){
					
					$csvs = readCSV($new_rugs_file);
					
				
				
					if($csvs)
					{
						$args = array(
						             'taxonomy'     => 'product_cat',
							         'hide_empty'               => 0,
						         );
						$cats = array();
						  
						$procats = get_categories( $args );
						foreach ($procats as $cat)
						{
							 $cats[$cat->name][0] = (int) $cat->term_id;
						}
						global $wpdb;
						$i =0;
                       
						foreach($csvs as $csv)
						{

                         
     						if(strcasecmp($csv[0],'Category')!=0)
     						{
	                      	csv_import_hard_flooring($csv,$appcats);

                     		}
		
		
						}



					} 
					else
					{
						echo 'Sorry file can\'t be uploaded';
					}
				}
				else{
					echo "File doesn't exixt";
				}
	}
	else{
           $counter = 1;
		$counterlength = 2;
		for($counter=1;$counter<=2;$counter++){
			if($counter==1){
		    $args = array(

				"post_type"=>'product',
				"post_status"=>array("pending"),
				"posts_per_page"=>"-1",
				'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => "hard-flooring"
                                )
                            )
			);
		$loop = new WP_Query($args);

		$i  = 1;
		echo "Pending Product List : <br />";
		while($loop->have_posts()){
			$loop->the_post();
			the_title();
			echo "<br />"; 
			$i++;
		}
		echo $i;
		wp_reset_query();
		$args = array(

				"post_type"=>'product',
				"post_status"=>array("publish"),
				"posts_per_page"=>"-1",
				'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => "hard-flooring"
                                )
                            )
			);
		$loop = new WP_Query($args);

		$i  = 1;echo "Draft Product List : <br />";
		while($loop->have_posts()){
			$loop->the_post();
			the_title();
			echo "<br />";
			wp_update_post(array('ID' => $loop->post->ID, 'post_status' => 'draft'));
		}
	
		wp_reset_query();
		$args = array(

				"post_type"=>'product',
				"post_status"=>array("pending"),
				"posts_per_page"=>"-1",
				'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => "hard-flooring"
                                )
                            )
			);
		$loop = new WP_Query($args);

		$i  = 1;echo "Updated Product List : <br />";
		while($loop->have_posts()){
			$loop->the_post();
			the_title();
			echo "<br />"; 
			wp_update_post(array('ID' => $loop->post->ID, 'post_status' => 'publish'));
			$i++;
		}
	
		wp_reset_query();
		}
		else{
			$args = array(

				"post_type"=>'product',
				"post_status"=>array("pending"),
				"posts_per_page"=>"-1",
				'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => "rugs"
                                )
                            )
			);
		$loop = new WP_Query($args);

		$i  = 1;
		echo "Draft Product List : <br />";
		while($loop->have_posts()){
			$loop->the_post();
			the_title();
			echo "<br />"; 
			$i++;
		}
		echo $i;
		wp_reset_query();
		$args = array(

				"post_type"=>'product',
				"post_status"=>array("publish"),
				"posts_per_page"=>"-1",
				'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => "rugs"
                                )
                            )
			);
		$loop = new WP_Query($args);

		$i  = 1;echo "Pending Product List : <br />";
		while($loop->have_posts()){
			$loop->the_post();
			the_title();
			echo "<br />";
			wp_update_post(array('ID' => $loop->post->ID, 'post_status' => 'draft'));
		}
	
		wp_reset_query();
		$args = array(

				"post_type"=>'product',
				"post_status"=>array("pending"),
				"posts_per_page"=>"-1",
				'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => "rugs"
                                )
                            )
			);
		$loop = new WP_Query($args);

		$i  = 1;echo "Updated Product List : <br />";
		while($loop->have_posts()){
			$loop->the_post();
			the_title();
			echo "<br />"; 
			wp_update_post(array('ID' => $loop->post->ID, 'post_status' => 'publish'));
			$i++;
		}
	
		wp_reset_query();
		}
		  
		} 


	}
}
}
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
			the_title();
			echo "<br />"; 
		wp_delete_post( $loop->post->ID, true ); 
		}
		wp_reset_query();


}