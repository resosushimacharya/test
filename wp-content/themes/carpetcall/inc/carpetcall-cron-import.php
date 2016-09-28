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

/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// HArdfloor file read ///////////////////////
/////////////////////////////////////////////////////////////////////////////////		
		
function data_database_read($termslug){
   $data = array(); 
   $args = array(
   			'post_type' => 'product',
   			'post_status' => 'publish',
   			'posts_per_page' => '-1',
   			'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => array($termslug)
                                )
                            )
   	);
   $loop = new WP_Query($args);
   while($loop->have_posts()){
   		$loop->the_post();
   		$sku = get_post_meta($loop->post->ID,'_sku',true);
   		$id = $loop->post->ID;
        $data[$sku] = array($sku,$id);

   }
   wp_reset_query();
   return $data;

}
function readCSV($csvFile)
{
	$file_handle = fopen($csvFile, 'r');
	$i=0;

 	while (!feof($file_handle) )
 	 {   
 	 	$temp = fgetcsv($file_handle, 0);
		$line_of_text[$temp[1]] = $temp;
 	 }
 	fclose($file_handle);
 	return $line_of_text;
}     


///////////////////////////////////////////////////////////////////////////
////////////////////////// cron fucntions ///////////////////////////////
////////////////////////////////////////////////////////////////////////
add_action( 'init', 'import_rugs_hard_schedule');
add_action('update_import_rugs_hard_hook','update_import_rugs_hard_function');

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
	
}
function update_import_rugs_hard_function(){
   cron_func_update();

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
/*
	* function to import Rugs products
	* will import products from uploaded CSV file
*/
function  csv_import_rugs($csv,$appcat,$resrugs,$import_fh,$rugs_fh)
{ 
    //fwrite($import_fh, "\n"."\r".'Testing...'.PHP_EOL); 
	set_time_limit(0) ;

	global $wpdb;
	$exist = get_page_by_title( $csv[1], OBJECT, 'product' );

	if($csv)
	{

		if(array_key_exists($csv[1], $resrugs)){
			
		
               $new_post_id =   $resrugs[$csv[1]][1];
			   fwrite($rugs_fh, "\n"."\r".'Product: '.$csv[1].'already Exists'.PHP_EOL);  
			   
			   echo $csv[1].'Rugs Item already exists'; 
		
	}
	else{
			$post = array(
					 'post_title'   => $csv[1],
					 'post_status'  => "publish",
					 'post_name'    => sanitize_title($csv[1]), //name/slug
					 'post_type'    => "product",
					 'post_content' => $csv[4],
					 'post_excerpt' => $csv[4]
				     );
	 
			
		$new_post_id = wp_insert_post( $post );
		if($new_post_id){
			fwrite($rugs_fh, "\n"."\r".'Product: '.$csv[1].' created.'.PHP_EOL); 
			update_post_meta( $new_post_id, 'total_sales', 0);
		}

	}
	    $rootcatterm = $appcat;	
		$slct        = $csv[3];
		$tlct        = $csv[2];
		if(!term_exists( $slct, 'product_cat', $rootcatterm ))
		{  
			fwrite($import_fh, "\n"."\r".'Second Level Category: '.$slct.' created.'.PHP_EOL); 
		   cc_category_second_level($slct ,$rootcatterm) ;
		   category_third_level($tlct ,$slct);
		   fwrite($import_fh, "\n"."\r".'Third Level Category: '.$tlct.' created.'.PHP_EOL); 
		}
		elseif(!term_exists($tlct,'product_cat',$tlct ))
		{
		  category_third_level($tlct ,$slct);
		  fwrite($import_fh, "\n"."\r".'Third Level Category: '.$tlct.' created.'.PHP_EOL); 	
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

							
			
						
					
		if($csv[13]!=0)
		{
	 		update_post_meta($new_post_id, '_stock_status', 'instock');
	        update_post_meta($new_post_id, '_stock', $csv[13]);
	        update_post_meta($new_post_id, '_manage_stock', 'yes');
			fwrite($rugs_fh, "\n"."\r".'Stock status Updated for Product: '.$csv[1].PHP_EOL); 
	    }
	    else
	    {
	        update_post_meta($new_post_id, '_stock_status', 'outofstock');
			fwrite($rugs_fh, "\n"."\r".'Product: '.$csv[1].'is out of stock'.PHP_EOL); 
	    }
		$hhh = $csv[14];
				
		$hh=explode(' ',$hhh);
	    
	    $length = str_replace("cm","","$hh[0]");
	    $width  =  str_replace("cm","","$hh[2]");
	    $height =  $hh[10];
		$weight = ($length/100)*($width/100)*$csv[15];
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
		update_post_meta( $new_post_id, '_weight', $weight );
		//update_post_meta( $new_post_id, '_weight', $csv[15] );
		update_post_meta( $new_post_id, '_regular_price', round($regular_price)  );
		update_post_meta( $new_post_id, '_sale_price', round($sale_price) );
		update_post_meta( $new_post_id, '_price', round($actual_price) );
		
		update_post_meta($new_post_id,'state',$csv[0]);
		update_post_meta( $new_post_id, '_visibility', 'visible' );
		update_post_meta( $new_post_id, '_length', $length);
		update_post_meta( $new_post_id, '_width', $width );
		update_post_meta( $new_post_id, '_height', $height);
		update_post_meta( $new_post_id, '_featured', 'no' );
	    update_post_meta($new_post_id,'discount',$csv[17]);
	   /* update_post_meta($new_post_id,'lateral_image_name',$csv[21]);
	    update_post_meta($new_post_id,'vertical_image_name',$csv[19]);
	    update_post_meta($new_post_id,'swatch_image_name',$csv[20]);*/
		
			$url= site_url().'/wp-content/uploads/products/';
               

			
   
		
		
	
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	

		fwrite($import_fh, "\n"."\r".'Product: '.$csv[1].' imported sucessfully'.PHP_EOL); 
		fwrite($rugs_fh, "\n"."\r".'Product: '.$csv[1].' imported sucessfully'.PHP_EOL); 
		echo 'Rugs Product '.$csv[1].' imported</br>';

	}
}


///////////////////////////////////////////////////////////////
/////////////// Import  Hardfloor csv function/////////////////////
//////////////////////////////////////////////////////////////
/*
	* function to import Hard Flooring products
	* will import products from uploaded CSV file
*/
	/*
	* function to import Hard Flooring products
	* will import products from uploaded CSV file
*/
	function  csv_import_hard_flooring($csv,$appcat,$reshardflooring,$import_fh,$hf_fh)
{   
	global $wpdb;
	set_time_limit(0) ;
	$exist = get_page_by_title( $csv[1], OBJECT, 'product' );
    
	if($csv)
	{

		if(array_key_exists($csv[1], $reshardflooring)){
			 
			 $new_post_id = $reshardflooring[$csv[1]][1];
			 echo $csv[1].'Hard Flooring Item already exists';
		     fwrite($hf_fh, "\n"."\r".'Product: '.$csv[1].'already Exists'.PHP_EOL);   

		
	 }
		else{
				$post = array(
						 'post_title'   => $csv[1],
						 'post_status'  => "publish",
						 'post_name'    => sanitize_title($csv[1]), //name/slug
						 'post_type'    => "product",
						 'post_content' => $csv[4],
						 'post_excerpt' => $csv[4]
					     );
		 
				
			$new_post_id = wp_insert_post( $post );
			if($new_post_id){
				fwrite($hf_fh, "\n"."\r".'Proudct '.$csv[1].' added'.PHP_EOL);
				update_post_meta( $new_post_id, 'total_sales', 0);
			}

		}

	 
		$rootcatterm = $appcat;		
		
		$slct        = $csv[0];
		$tlct        = $csv[3];
		
		/*$rootcatterm  =  str_replace('_', ' ', $rootcatterm);
		$rootcatterm   = ucwords($rootcatterm);*/
		if(!term_exists( $slct, 'product_cat', $rootcatterm ))
		{  
		   cc_category_second_level($slct ,$rootcatterm) ;
		   fwrite($import_fh, "\n"."\r".'Second Level Category: '.$slct.' created'.PHP_EOL);
		   category_third_level($tlct ,$slct);
		    fwrite($import_fh, "\n"."\r".'Third Level Category: '.$tlct.' created'.PHP_EOL);
		}
		elseif(!term_exists($tlct,'product_cat',$tlct ))
		{
		  category_third_level($tlct ,$slct);	
		  fwrite($import_fh, "\n"."\r".'Third Level Category: '.$tlct.' created'.PHP_EOL);
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
		

							
						
					
		if($csv[2]!=0)
		{
	 		update_post_meta($new_post_id, '_stock_status', 'instock');
	        update_post_meta($new_post_id, '_stock', $csv[2]);
	        update_post_meta($new_post_id, '_manage_stock', 'yes');
			fwrite($hf_fh, "\n"."\r".'Stock Quantity Updated for: '.$csv[1].' to '.$csv[2].PHP_EOL);
	    }
	    else
	    {
	        update_post_meta($new_post_id, '_stock_status', 'outofstock');
			fwrite($hf_fh, "\n"."\r".'Product: '.$csv[1].' is out of stock'.PHP_EOL);
	    }
		
	    $regular_price = str_replace(' ', '', $csv[44]);
	  
	  
	     
	    

	     $regular_price = ltrim($regular_price, '0');
	
	

	   
	   
	  	
		
	    
		update_post_meta( $new_post_id, '_sku', $csv[1]);
		$item_sku =  $csv[1];
	
		
		
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
        /*update_post_meta($new_post_id,'lateral_image_name',$csv[47]);
	    update_post_meta($new_post_id,'vertical_image_name',$csv[46]);
	    update_post_meta($new_post_id,'swatch_image_name',$csv[48]);*/
       
 
        	update_post_meta( $new_post_id, 'instructional_video',$csv[49]);
       
		/* end option section */

       /*    */
       $width  =  str_replace("mm","",$csv[13]);
       $length  = str_replace("mm","",$csv[12]);
       $thick = str_replace("mm","",$csv[15]);
		update_post_meta( $new_post_id, '_regular_price', round($regular_price) );
		update_post_meta( $new_post_id, '_sales_price', round($regular_price) );
		
		update_post_meta( $new_post_id, '_price', round($regular_price) );
		update_post_meta($new_post_id,'state',$csv[0]);
		update_post_meta( $new_post_id, '_visibility', 'visible' );
		update_post_meta( $new_post_id, '_length', $length);
		update_post_meta( $new_post_id, '_width', $width );
		update_post_meta( $new_post_id, '_height', $thick);
		update_post_meta( $new_post_id, 'product_thickness_veneer', $csv[14]);
		update_post_meta( $new_post_id, '_featured', 'no' );
	    update_post_meta($new_post_id,'discount',$csv[17]);
	
	  
			$url= site_url().'/wp-content/uploads/products/';
               

			
   
	
	
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		
		fwrite($import_fh, "\n"."\r".'Product: '.$csv[1].' imported sucessfully'.PHP_EOL);
		fwrite($hf_fh, "\n"."\r".'Product: '.$csv[1].' imported sucessfully.'.PHP_EOL);
		echo 'Hard Flooring Product '.$csv[1].' imported</br>';
	}
}
// end of hard flooring read section //

/////////////////////////////////////////////////////////////////////////
/////////////////////////////Import Product Function //////////////////
////////////////////////////////////////////////////////////////////////

//add_action("admin_init",'cron_func_update');
function cron_func_update(){

$file = WP_CONTENT_DIR.'/mylog.txt';
$fh = fopen($file, "a");
$new_log= 'CSV IMPORT Cron started at '.date("Y-m-d H:i:s");
fwrite($fh, "\n"."\r".$new_log.PHP_EOL);
fclose($fh);

$import_log =  WP_CONTENT_DIR.'/import-logs/logs'.date("Ymd").'.txt';
$import_fh = fopen($import_log, "a");
fwrite($import_fh, "\n"."\r".'Import Started'.PHP_EOL);

$rugs_import_log =  WP_CONTENT_DIR.'/import-logs/rugs_log'.date("Ymd").'.txt';
$rugs_fh = fopen($rugs_import_log, "a");
fwrite($rugs_fh, "\n"."\r".'Rugs Prouducts Import Started:'.PHP_EOL);

$hf_import_log =  WP_CONTENT_DIR.'/import-logs/hf_log'.date("Ymd").'.txt';
$hf_fh = fopen($hf_import_log, "a");
fwrite($hf_fh, "\n"."\r".'Hard Flooring Prouducts Import Started:'.PHP_EOL);


$rugsadmin = data_database_read("rugs");
$hardflooringadmin = data_database_read("hard-flooring");



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
$time =  current_time('Y-m-d-H-i-s');
 $date =current_time('Y-m-d');
$newfilename = $desfolder.'log.txt';
fwrite($import_fh, "\n"."\r".'Import Started at: '.date("Y-m-d H:i:s").PHP_EOL);

$txt = "\r\n Import has been started in ".$time." \r\n";
file_put_contents($newfilename, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);


if(strcasecmp($url[2],'localhost')==0){
    $directory = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/productfiles';}
else{
    $directory = $_SERVER['DOCUMENT_ROOT'].'/productfiles';
}

$csc_rugs_flag=$csc_hardfloor_flag=false;

$rugs_post_ids= $hard_post_ids=array();
$filecols = array_diff(scandir($directory), array('..', '.'));

if($filecols){


foreach($filecols as $fileitem){
    if (strpos(strtolower($fileitem), 'rugols') !== false) {
        $fileextension = explode('.',$fileitem);
        if($fileextension[1]=='csv'){
        //$rugfilesearray[] = $fileitem ;
            $rugs_post_ids[]=cc_csv_conv_array($fileitem );
            $csc_rugs_flag=true;
        }
        else{
			fwrite($import_fh, "\n"."\r".'Undefined File('.$fileitem.')'.PHP_EOL);
            echo "undefined file($fileitem) for rugs.";
        }
           //to name the history files with date
        $filedesarr= explode('.',$fileitem);
        
        $filedesname = $filedesarr[0].'-'.$date.'.'.$filedesarr[1];
          if(!copy($directory.'/'.$fileitem, $desfolder.$filedesname)){
    		
			fwrite($import_fh, "\n"."\r".'Error Copying the File('.$fileitem.')'.PHP_EOL);
          	echo "file ".$fileitem." hasn't been copied.";
			
          }
           if(!unlink($directory.'/'.$fileitem)){
			fwrite($import_fh, "\n"."\r".'Error Deleting the File('.$fileitem.')'.PHP_EOL);
           	echo "file".$fileitem."hasn't been deleted.";
           }
    }
    elseif(strpos(strtolower($fileitem), 'lols') !== false){
        $fileextension = explode('.',$fileitem);
        if($fileextension[1]=='csv'){
            //$hardfloorfilesarray[] = $fileitem;
            $hards_post_ids[]=cc_csv_conv_array( $fileitem);
            $csc_hardfloor_flag=true;

        }
        else{
			fwrite($import_fh, "\n"."\r".'Undefined file('.$fileitem.') for hardflooring'.PHP_EOL);
            echo "undefined file($fileitem) for hardflooring.";
        }
        //to name the history files with date
        $filedesarr= explode('.',$fileitem);
        
        $filedesname = $filedesarr[0].'-'.$date.'.'.$filedesarr[1];

       if(!copy($directory.'/'.$fileitem, $desfolder.$filedesname)){
		   fwrite($import_fh, "\n"."\r".'Error Copying the file('.$fileitem.PHP_EOL);
          	echo "file ".$fileitem." hasn't been copied.";
			
          }
           if(!unlink($directory.'/'.$fileitem)){
			fwrite($import_fh, "\n"."\r".'Error Deleting the file('.$fileitem.') for hardflooring'.PHP_EOL);
           	echo "file".$fileitem."hasn't been deleted.";
           }
    }
    else{
        $errorfilesarray[] = $fileitem;
        $errorflag = true;
           //to name the history files with date
        $filedesarr= explode('.',$fileitem);
        
        $filedesname = $filedesarr[0].'-'.$date.'.'.$filedesarr[1];
          if(!copy($directory.'/'.$fileitem, $desfolder.$filedesname)){
          	 fwrite($import_fh, "\n"."\r".'Error Copying the file('.$fileitem.PHP_EOL);
			echo "file ".$fileitem." hasn't been copied.";
			
          }
           if(!unlink($directory.'/'.$fileitem)){
			fwrite($import_fh, "\n"."\r".'Error Deleting the file('.$fileitem.') for hardflooring'.PHP_EOL);   
           	echo "file".$fileitem."hasn't been deleted.";
           }
    }

} 



if($csc_hardfloor_flag){
$new_rugs_file = cc_res_csv_hards($hards_post_ids,'NETLOLS');
$appcat = "hard-flooring";
if(file_exists($new_rugs_file)){
					
					
					$reshardflooring = array();
				    	
				

					 $csvs = readCSV($new_rugs_file);
					
					 foreach($hardflooringadmin as $key=>$value){
					


					 	if(array_key_exists($key, $csvs))
					 	{
					 		
					 		 	$reshardflooring[$key] = $value;
					 	}
					 	else{
					 		wp_delete_post($value[1]);
					 		fwrite($hf_fh, "\n"."\r".'Product '.$key.' has been deleted.'.PHP_EOL);

					 	}
					 	
					 }
				
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
	                      	csv_import_hard_flooring($csv,$appcat,$reshardflooring,$import_fh,$hf_fh);

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



if($csc_rugs_flag){
$new_rugs_file = cc_res_csv_rugs($rugs_post_ids,'NETRUGOLS');
 $appcat = "rugs";
    if(file_exists($new_rugs_file)){
					 $resrugs = array();

					 $csvs = readCSV($new_rugs_file);
					
					 foreach($rugsadmin as $key=>$value){
					


					 	if(array_key_exists($key, $csvs))
					 	{
					 	
					 		 	
					 		 	$resrugs[$key] = $value;
					 	}
					 	else{
					 		fwrite($hf_fh, "\n"."\r".'Product '.$key.' has been deleted.'.PHP_EOL);
					 		wp_delete_post($value[1]);

					 	}
					 	
					 }
					
					
				
					
				
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
	                      		csv_import_rugs($csv,$appcat,$resrugs,$import_fh,$rugs_fh);

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

		$txt = "In ".$time."\r\nList of error files \r\n";
		if($errorflag){
		foreach($errorfilesarray as $efa){

			$txt .= $efa."\r\n" ;
		   }
	     } else{
           $txt .= "No error files ." ;
	     }
	     $time =  current_time('Y-m-d-h-i-s');
		 file_put_contents($newfilename, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
			
}
else{
	$time =  current_time('Y-m-d-h-i-s');
	$txt = "In ".$time."\r\n prdouctfiles folder is empty \r\n";
	fwrite($import_fh, "\n"."\r".'Product files Folder is empty'.PHP_EOL);
		
		 file_put_contents($newfilename, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

}
// this else condition is for empy folders



$time =  current_time('Y-m-d-h-i-s');

$txt = "\r\n Import has been finished in ".$time."\r\n";
fwrite($import_fh, "\n"."\r".'Import Finished at: '.date("Y-m-d H:i:s").PHP_EOL);
file_put_contents($newfilename, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		
fclose($import_fh);
fclose($hf_fh);
fclose($rugs_fh);

}
function cc_csv_conv_array($filename){

	$url = site_url();
$url = explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
    $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/productfiles/';}
else{
    $desfolder= $_SERVER['DOCUMENT_ROOT'].'/productfiles/';
}
$filename = $desfolder.$filename;
$file = fopen($filename,"r");
$count_csv = 0;
$arraycsv = array();
while(! feof($file))
{
$arraycsv[] =fgetcsv($file);
$count_csv++;
}
fclose($file); 
$arraycsvff = array();
foreach($arraycsv as $arraycsvu){
$arraycsvff[$arraycsvu[1]]=$arraycsvu;
}
return  $arraycsvff;
}


/////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////csv file reads ///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

function cc_res_csv_rugs ( $rugs_post_ids,$filename ) {

    $new_rugs_ids=array();
    foreach($rugs_post_ids as $rugs_ids){

        foreach($rugs_ids as $rugs){
            if(strcasecmp($rugs[0],'state')==0){
                continue;
            }

            if(array_key_exists($rugs[1],$new_rugs_ids)){
                $old_item=$new_rugs_ids[$rugs[1]];
                $qty= intval($old_item[13])+intval($rugs[13]);
                $old_item[13]=$qty;
                $new_rugs_ids[$rugs[1]]=$old_item;

            }else{
                $new_rugs_ids[$rugs[1]]=$rugs;
            }


      }

    }
    $url = site_url();
    $url = explode('/',$url);
    if(strcasecmp($url[2],'localhost')==0){
        $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/netcsvs/';
    }else{
        $desfolder= $_SERVER['DOCUMENT_ROOT'].'/netcsvs/';
    }
        $time =  current_time('Y-m-d-h-i-s');
        $resfile = $desfolder.$filename.$time.'.csv';
    $fp = fopen($desfolder.$filename.$time.'.csv', 'w');
    foreach($new_rugs_ids as $writeline){
        fputcsv($fp, $writeline);

    }
    fclose($fp);

   
    return $resfile;

}

function cc_res_csv_hards($hards_post_ids,$filename){ 
     $new_hards_ids=array();
      foreach($hards_post_ids as $hards_ids){

          foreach($hards_ids as $hards){
              if(strcasecmp($hards[0],'category')==0){
                  continue;
              }

              if(array_key_exists($hards[1],$new_hards_ids)){
                  $old_item=$new_hards_ids[$hards[1]];
                  $qty= intval($old_item[2])+intval($hards[2]);
                  $old_item[2]=$qty;
                  $new_hards_ids[$hards[2]]=$old_item;

              }else{
                  $new_hards_ids[$hards[2]]=$hards;
              }


        }

      }
      $url = site_url();
      $url = explode('/',$url);
      if(strcasecmp($url[2],'localhost')==0){
          $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/netcsvs/';
      }else{
          $desfolder= $_SERVER['DOCUMENT_ROOT'].'/netcsvs/';
      }
          $time =  current_time('Y-m-d-h-i-s');
      $resfile = $desfolder.$filename.$time.'.csv';
      $fp = fopen($desfolder.$filename.$time.'.csv', 'w');
      foreach($new_hards_ids as $writeline){
          fputcsv($fp, $writeline);

      }
      fclose($fp);
      return $resfile;


}







?>


