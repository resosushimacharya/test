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
function import_css_products(){
	add_submenu_page( 'edit.php?post_type=product', 'CSV Import ', 'CSV Import', 'manage_options', 'css-products-import', 'css_products_import' );
}
function readCSV($csvFile){
 $file_handle = fopen($csvFile, 'r');
 $i=0;

 while (!feof($file_handle) ) {
	$line_of_text[] = fgetcsv($file_handle, 0);
 }
 fclose($file_handle);
 return $line_of_text;
}
function  csv_import_rugs($csv){
	/*do_action('pr',$_POST);*/

							$exist = get_page_by_title( $csv[1], OBJECT, 'product' );
			if($csv && !isset($exist->ID)){
				
				   /*do_action('pr',$exist);*/
				$post = array(
						 'post_title'   => $csv[1],
						 'post_status'  => "publish",
						 'post_name'    => sanitize_title($csv[1]), //name/slug
						 'post_type'    => "product",
						 'post_content' =>$csv[4],
						 'post_excerpt' =>$csv[4]
					);
	 
				
				$new_post_id = wp_insert_post( $post );
				
				
				$main_cat=get_term_by( 'name', $csv[3], 'product_cat');
				$sub_cat=get_term_by( 'name', $csv[2], 'product_cat');

				wp_set_object_terms( $new_post_id, $main_cat->slug, 'product_cat',true);
				wp_set_object_terms( $new_post_id, $sub_cat->slug, 'product_cat',true);

							
				
				//########################## Done adding attributes to product #################
							$transient_name = 'wc_product_children_ids_' . $new_post_id;
							delete_transient( $transient_name );					
				
					
			  if($csv[13]!=0){
                                    update_post_meta($new_post_id, '_stock_status', 'instock');
                                    update_post_meta($new_post_id, '_stock', $csv[13]);
                                    update_post_meta($new_post_id, '_manage_stock', 'yes');
                                }
                                else{
                                    update_post_meta($new_post_id, '_stock_status', 'outofstock');
                                }
				$hhh = $csv[14];
				
				$hh=explode(' ',$hhh);
  $hh[0];
  $length= str_replace("cm","","$hh[0]");
  $width= str_replace("cm","","$hh[2]");
  $height =$hh[10];
  
                update_post_meta($new_post_id,'state',$csv[0]);
				update_post_meta( $new_post_id, '_sku', $csv[1]);
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
				 $swatch = $url.$csv[19].'.jpg';
				 $side = $url.$csv[20].'.jpg';
				 $life = $url.$csv[21].'.jpg';
			     require_once(ABSPATH . 'wp-admin/includes/file.php');
			     require_once(ABSPATH . 'wp-admin/includes/media.php');
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				 $tmp = download_url( $swatch );



					$image_id=array();
					
					preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $swatch, $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
					
					if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
					}
					
					
					$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
					
					if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);
					
					}
					
					$set = set_post_thumbnail($new_post_id, $thumbid);
						if(!is_wp_error($thumbid)){
						$image_id[]=$thumbid;
					}


					$tmp = download_url( $side );

					preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/',  $side , $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
					
					if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
					}
					
				
					$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
					
					if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);
					
					}
					
						if(!is_wp_error($thumbid)){
						$image_id[]=$thumbid;
					}


					$tmp = download_url( $life );

					preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $life , $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
					
					if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
					}
					
					
					$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
				
					if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);
					
					}
					
					if(!is_wp_error($thumbid)){
						$image_id[]=$thumbid;
					}
					
				update_post_meta( $new_post_id, '_product_image_gallery', implode(",",$image_id));


       




					echo 'Rugs Product '.$csv[1].' imported</br>';
	
			} else  {
				if(isset($exist->ID)){
					echo $csv[1].'Rugs Item already exists';
				}
			}
}
function css_products_import(){
	echo '<h1>CSV Import</h1>';
	if(isset($_POST['submit'])&& $_POST['choice']=="rugs"){
		  
		$mimes = array('application/vnd.ms-excel');	
		
		if(in_array($_FILES['importcsv']['type'],$mimes)){
			 if ($_FILES["importcsv"]["error"] > 0){
                echo "Error Code: " . $_FILES["importcsv"]["error"];
             }
		else{
			$new_file_name = strtolower($_FILES['importcsv']['name']);
			if(file_exists(TEMPLATEPATH.'/csv/'.$new_file_name)) unlink(TEMPLATEPATH.'/csv/'.$new_file_name);
				if(move_uploaded_file($_FILES['importcsv']['tmp_name'], TEMPLATEPATH.'/csv/'.$new_file_name)){
					
					$csvFile = TEMPLATEPATH.'/csv/'.$new_file_name;
					$csvs = readCSV($csvFile);
						if($csvs){
						  $args = array(
							 'taxonomy'     => 'product_cat',
							 'hide_empty'               => 0,
						  );
						  $cats = array();
						  
						 $procats = get_categories( $args );
						 foreach ($procats as $cat){
							 $cats[$cat->name][0] = (int) $cat->term_id;
						 }
						global $wpdb;
						$i =0;
                       
						foreach($csvs as $csv){

                         
                  if(strcasecmp($csv[0],'state')!=0){
	                      csv_import_rugs($csv);

		                     }
		
		
					}



				} else {echo 'Sorry file can\'t be uploaded';}
			}
}

		} else { 
			if(empty($_FILES['importcsv']['type']))
			{ echo "you haven't uploaded any file.";}
		 else{

  			echo "Sorry, File type ".$_FILES['importcsv']['type']." is not supported";
		 }

		}
	}
	
	?>
	<div class="container" class="import_csv_container">
<form method="post" enctype="multipart/form-data" class="import_csv_form">
<h2 for="">Select CSV file to import:</h2>
    <p><input type="file" name="importcsv" id="importcsv" class="import_csv_input"></p>
    <p><label for="import_csv_radio_left">Rugs</label> <input type="radio" name="choice" value="rugs" class="import_csv_radio_left" id="import_csv_radio_left">
     <label for="import_csv_radio_right">Hard Flooring </label><input type="radio" name="choice" value="hard-flooring" class="import_csv_radio_right" id="import_csv_radio_right"></p>
     <input type="hidden" value="123" name="hidden_field"/>
    <input type="submit" value="Import" name="submit">
</form>
</div>
<?php

}




