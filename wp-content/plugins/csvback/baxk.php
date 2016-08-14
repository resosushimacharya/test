<?php 
/*
Plugin Name: CSV
Description: Description
Plugin URI: http://#
Author: Author
Author URI: http://#
*/

/*

    Copyright (C) Year  Author  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_action('admin_menu', 'import_css_products');
/*
	* function to make sub-menu in side bar navigation 
	* it comes inside product menu
*/

function import_css_products()
{
	add_submenu_page( 'edit.php?post_type=product', 'CSV Import ', 'CSV Import', 'manage_options', 'css-products-import', 'css_products_import' );
}
/*
 *checking whether to presence of second level category term in product_cat
  *it will add term if not present...
*/
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
function  csv_import_rugs($csv)
{
	$exist = get_page_by_title( $csv[1], OBJECT, 'product' );

	if($csv && !isset($exist->ID))
	{
		$post = array(
					 'post_title'   => $csv[1],
					 'post_status'  => "publish",
					 'post_name'    => sanitize_title($csv[1]), //name/slug
					 'post_type'    => "product",
					 'post_content' => $csv[4],
					 'post_excerpt' => $csv[4]
				     );
	 
		$rootcatterm = $_POST['choice'];		
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
		update_post_meta( $new_post_id, '_regular_price', $csv[16] );
		update_post_meta( $new_post_id, '_sale_price', $csv[18] );
		update_post_meta( $new_post_id, '_price', $csv[18] );
		update_post_meta($new_post_id,'state',$csv[0]);
		update_post_meta( $new_post_id, '_visibility', 'visible' );
		update_post_meta( $new_post_id, '_length', $length);
		update_post_meta( $new_post_id, '_width', $width );
		update_post_meta( $new_post_id, '_height', $height);
		update_post_meta( $new_post_id, '_featured', 'no' );
	    update_post_meta($new_post_id,'discount',$csv[17]);
		$url= 'http://www.carpetcall.com.au/downloads/Image/products/large/';
		$swatch = $url.$csv[20].'.jpg';
		$life = $url.$csv[21].'.jpg';
		$side = $url.$csv[19].'.jpg';
		
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		$tmp = download_url($life);
		$x=4;
		if ( is_wp_error( $tmp ) )
	 	{ $tmp = download_url($side);
	 		$life = $side;
	 		if ( is_wp_error( $tmp ) ){
	 			$tmp = download_url($swatch);
	 			$life = $swatch;
	 			
	 		}
	      $x=5;
	 	}
		$image_id=array();
		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $life, $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
		if ( is_wp_error( $tmp ) )
	 	{ 
	
			@unlink($file_array['tmp_name']);

			
			$file_array['tmp_name'] = '';
		}
					
					
		$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
					
		if ( is_wp_error($thumbid) ) 
		{
		
			@unlink($file_array['tmp_name']);
					
		}
					
		$set = set_post_thumbnail($new_post_id, $thumbid);
		if(!is_wp_error($thumbid) && ($x!=5))
		{
			$image_id[]=$thumbid;
		}


		$tmp = download_url( $side );
	

		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/',  $side , $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
					
		if ( is_wp_error( $tmp ) ) 
		{
			@unlink($file_array['tmp_name']);
			$file_array['tmp_name'] = '';
		}
					
				
		$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
					
		if ( is_wp_error($thumbid) )
	 	{
			@unlink($file_array['tmp_name']);
					
		}
					
		if(!is_wp_error($thumbid))
		{
			$image_id[]=$thumbid;
		}


		$tmp = download_url( $swatch );
	
		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $swatch , $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
					
		if ( is_wp_error( $tmp ) )
		{
			@unlink($file_array['tmp_name']);
			$file_array['tmp_name'] = '';
		}
					
					
		$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
				
		if ( is_wp_error($thumbid) )
		{
			@unlink($file_array['tmp_name']);
					
		}
					
		if(!is_wp_error($thumbid))
		{
			$image_id[]=$thumbid;
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
	function  csv_import_hard_flooring($csv)
{
	$exist = get_page_by_title( $csv[1], OBJECT, 'product' );

	if($csv && !isset($exist->ID))
	{
		$post = array(
					 'post_title'   => $csv[1],
					 'post_status'  => "publish",
					 'post_name'    => sanitize_title($csv[1]), //name/slug
					 'post_type'    => "product",
					 'post_content' => $csv[7],
					 'post_excerpt' => $csv[7]
				     );
	 
		$rootcatterm = $_POST['choice'];		
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
        \update_post_meta( $new_post_id, 'wear_layer_warranty', $csv[32] );
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
		update_post_meta( $new_post_id, '_regular_price', $csv[44] );
		/*update_post_meta( $new_post_id, '_sale_price', $csv[44] );*/
		update_post_meta( $new_post_id, '_price', $csv[44] );
		update_post_meta($new_post_id,'state',$csv[0]);
		update_post_meta( $new_post_id, '_visibility', 'visible' );
		update_post_meta( $new_post_id, '_length', $length);
		update_post_meta( $new_post_id, '_width', $width );
		update_post_meta( $new_post_id, '_height', $thick);
		update_post_meta( $new_post_id, 'product_thickness_veneer', $csv[14]);
		update_post_meta( $new_post_id, '_featured', 'no' );
	    update_post_meta($new_post_id,'discount',$csv[17]);
		$url= 'http://www.carpetcall.com.au/downloads/Image/products/large/';
		$swatch = $url.$csv[48].'.jpg';
		$life = $url.$csv[47].'.jpg';
		$side = $url.$csv[46].'.jpg';
		
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		$tmp = download_url($life);
		$x=4;
		if ( is_wp_error( $tmp ) )
	 	{ $tmp = download_url($side);
	 		$life = $side;
	 		if ( is_wp_error( $tmp ) ){
	 			$tmp = download_url($swatch);
	 			$life = $swatch;
	 			
	 		}
	      $x=5;
	 	}
		$image_id=array();
		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $life, $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
		if ( is_wp_error( $tmp ) )
	 	{ 
	
			@unlink($file_array['tmp_name']);

			
			$file_array['tmp_name'] = '';
		}
					
					
		$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
					
		if ( is_wp_error($thumbid) ) 
		{
		
			@unlink($file_array['tmp_name']);
					
		}
					
		$set = set_post_thumbnail($new_post_id, $thumbid);
		if(!is_wp_error($thumbid) && ($x!=5))
		{
			$image_id[]=$thumbid;
		}


		$tmp = download_url( $side );
	

		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/',  $side , $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
					
		if ( is_wp_error( $tmp ) ) 
		{
			@unlink($file_array['tmp_name']);
			$file_array['tmp_name'] = '';
		}
					
				
		$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
					
		if ( is_wp_error($thumbid) )
	 	{
			@unlink($file_array['tmp_name']);
					
		}
					
		if(!is_wp_error($thumbid))
		{
			$image_id[]=$thumbid;
		}


		$tmp = download_url( $swatch );
	
		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $swatch , $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
					
		if ( is_wp_error( $tmp ) )
		{
			@unlink($file_array['tmp_name']);
			$file_array['tmp_name'] = '';
		}
					
					
		$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
				
		if ( is_wp_error($thumbid) )
		{
			@unlink($file_array['tmp_name']);
					
		}
					
		if(!is_wp_error($thumbid))
		{
			$image_id[]=$thumbid;
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
function css_products_import()
{
	echo '<h1>CSV Import</h1>';
	if(isset($_POST['submit']) &&  isset($_POST['choice']) && ($_POST['choice']=="rugs"))
	{
		  
		$mimes = array('application/vnd.ms-excel');	
		
		if(in_array($_FILES['importcsv']['type'],$mimes))
		{
			if ($_FILES["importcsv"]["error"] > 0)
			{
                echo "Error Code: " . $_FILES["importcsv"]["error"];
            }
		    else
		    {
				$new_file_name = strtolower($_FILES['importcsv']['name']);
			    if(file_exists(TEMPLATEPATH.'/csv/'.$new_file_name)) unlink(TEMPLATEPATH.'/csv/'.$new_file_name);
				if(move_uploaded_file($_FILES['importcsv']['tmp_name'], TEMPLATEPATH.'/csv/'.$new_file_name))
				{
					$csvFile = TEMPLATEPATH.'/csv/'.$new_file_name;
					
					$csvs = readCSV($csvFile);
					$fn = explode('.',$new_file_name);
				
					
					if(strcasecmp($fn[0] ,"rugs")!=0){
						echo '
						<div class="wrap"><ul class="subsubsub">
	<li class="all">Please select correct file to upload Hard Flooring / Rugs products .
	</li></ul>
<br clear="all">
<ul>
<li class="all">
	<a href ="'.site_url().'/wp-admin/edit.php?post_type=product&page=css-products-import" class="modifcation-hover" >Go Back.</a>
	</li></ul></div>';
						die();

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
	                      		csv_import_rugs($csv);

                     		}
		
		
						}



					} 
					else
					{
						echo 'Sorry file can\'t be uploaded';
					}
				}
			}

		}
		else
 		{ 
			if(empty($_FILES['importcsv']['type']))
			{ 
				echo "you haven't uploaded any file.";
			}
			else
			{

  			echo "Sorry, File type ".$_FILES['importcsv']['type']." is not supported";
			}

		}
	}
	elseif(isset($_POST['submit']) &&  isset($_POST['choice']) && ($_POST['choice']=="hard-flooring")){

     $mimes = array('application/vnd.ms-excel');	
		
		if(in_array($_FILES['importcsv']['type'],$mimes))
		{
			if ($_FILES["importcsv"]["error"] > 0)
			{
                echo "Error Code: " . $_FILES["importcsv"]["error"];
            }
		    else
		    {
				$new_file_name = strtolower($_FILES['importcsv']['name']);
			    if(file_exists(TEMPLATEPATH.'/csv/'.$new_file_name)) unlink(TEMPLATEPATH.'/csv/'.$new_file_name);
				if(move_uploaded_file($_FILES['importcsv']['tmp_name'], TEMPLATEPATH.'/csv/'.$new_file_name))
				{
					$csvFile = TEMPLATEPATH.'/csv/'.$new_file_name;
					$csvs = readCSV($csvFile);
					$fn = explode('.',$new_file_name);
				
					
					if(strcasecmp($fn[0] ,"hard-flooring")!=0){
							echo '<div class="wrap"><ul class="subsubsub">
	<li class="all">Please select correct file to upload Hard Flooring / Rugs products .
	</li></ul>
<br clear="all">
<ul>
<li class="all">
	<a href ="'.site_url().'/wp-admin/edit.php?post_type=product&page=css-products-import" class="modifcation-hover" >Go Back.</a>
	</li></ul></div>';
					
						
						die();

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
	                      		csv_import_hard_flooring($csv);

                     		}
		
		
						}



					} 
					else
					{
						echo 'Sorry file can\'t be uploaded';
					}
				}
			}

		}
		else
 		{ 
			if(empty($_FILES['importcsv']['type']))
			{ 
				echo "you haven't uploaded any file.";
			}
			else
			{

  			echo "Sorry, File type ".$_FILES['importcsv']['type']." is not supported";
			}

		}
	}
	
	?>
<div class="container" class="import_csv_container">
	<form method="post" enctype="multipart/form-data" class="import_csv_form">
		<h2 for="">Select CSV file to import:</h2>
    	<p>
    		<input type="file" name="importcsv" id="importcsv" class="import_csv_input" required>
    	</p>
        <p>
        	<label for="import_csv_radio_left">Rugs</label>
        	<input type="radio" name="choice" value="rugs" class="import_csv_radio_left" id="import_csv_radio_left" required>
     		<label for="import_csv_radio_right">Hard Flooring </label>
     		<input type="radio" name="choice" value="hard-flooring" class="import_csv_radio_right" id="import_csv_radio_right" required>
 		</p>
     	<input type="submit" value="Import" name="submit">
     </form>
</div>
<?php

}




