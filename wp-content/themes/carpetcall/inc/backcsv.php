<?php add_action('admin_menu', 'import_css_products');
function import_css_products(){
	add_submenu_page( 'edit.php?post_type=product', 'Products Import', 'Products Import', 'manage_options', 'css-products-import', 'css_products_import' );
}
function readCSV($csvFile){
 $file_handle = fopen($csvFile, 'r');
 while (!feof($file_handle) ) {
  $line_of_text[] = fgetcsv($file_handle, 0);
 }
 fclose($file_handle);
 return $line_of_text;
}

function css_products_import(){
	echo '<h1>Products Imports</h1>';
	if(isset($_POST['submit'])){
		$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
		
		if(in_array($_FILES['importcsv']['type'],$mimes)){
			 if ($_FILES["importcsv"]["error"] > 0){
                echo "Error Code: " . $_FILES["importcsv"]["error"];
             }
        		else{
				$new_file_name = strtolower($_FILES['importcsv']['name']);
				if(file_exists(TEMPLATEPATH.'/csvs/'.$new_file_name)) unlink(TEMPLATEPATH.'/csvs/'.$new_file_name);
				if(move_uploaded_file($_FILES['importcsv']['tmp_name'], TEMPLATEPATH.'/csvs/'.$new_file_name)){
					// Set path to CSV file
					$csvFile = TEMPLATEPATH.'/csvs/'.$new_file_name;

					//calling the function
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
						$i =1;
						foreach($csvs as $csv){
							$exist = get_page_by_title( $csv[1], OBJECT, 'product' );
			if($csv && !isset($exist->ID)){
				$i++;
				//echo '<pre>';
				//var_dump($csv);die;
				$post = array(
						 'post_title'   => $csv[1],
						 'post_status'  => "publish",
						 'post_name'    => sanitize_title($csv[1]), //name/slug
						 'post_type'    => "product",
						 'post_content'    =>$csv[5],
						 'post_excerpt' =>$csv[4]
					);
	 
				//var_dump($cats[$csv[0]]);die;
				//Create product/post:
				$new_post_id = wp_insert_post( $post );
				//var_dump($new_post_id);die;
				//make product type be variable:
				$return = wp_set_object_terms ($new_post_id,'variable','product_type');
				//add category to product:
				// wp_set_object_terms( $object_id, $terms, $taxonomy, $append );
				
				$category_list=	array();
				$category_list[6] ='hazard';
				$category_list[7]='prohibition';
				$category_list[8]='mandatory';
				$category_list[9]='safe-condition';
				$category_list[10]='fire';
				$category_list[11]='dangerous-goods';
				$category_list[12]='vehicle-parking';
				$category_list[13]='waste-management';
				$category_list[14]='safety-awareness';
				$category_list[15]='environmental-awareness';
				$category_list[16]='electrical';
				$category_list[17]='fire-explosion';
				$category_list[18]='hazardous-substances';
				$category_list[19]='hazardous-areas';
				$category_list[20]='slips-rips-falls';
				$category_list[21]='machinery-equipment';
				$category_list[22]='access';
				$category_list[23]='smoking';
				$category_list[24]='ppe';
				$category_list[25]='housekeeping-hygiene';
				$category_list[26]='first-aid';
				$category_list[27]='exit-assembly-point';
				$category_list[28]='water-safety';
				$category_list[29]='property-security';
				$category_list[30]='child-safety';
				$category_list[31]='animal-safety';
				$category_list[32]='construction';
				$category_list[33]='factory';
				$category_list[34]='warehouse';		
				$category_list[35]='farm-agribusiness';
				$category_list[36]='food-drinks-industry';
				$category_list[37]='office';
				$category_list[38]='chemical-pharmaceutical';
				$category_list[39]='electronics-tech';
				$category_list[40]='water-energy-plant';
				$category_list[41]='hospitality-tourism';
				$category_list[42]='community-recreational';
				$category_list[43]='medical-healthcare';
				$category_list[44]='retail';
				$category_list[45]='school';
				$category_list[46]='events';
									
				foreach($category_list as $key=>$value){
					if(trim($csv[$key])=="1"){
						$ret = wp_set_object_terms( $new_post_id, $value, 'product_cat',true);
					}
				}
				
				//################### Add  attributes to main product: ####################
				//Array for setting attributes
				 if($csv[2] == 1){
				$sizes = array('100mm x 150mm','200mm x 300mm','300mm x 450mm','400mm x 600mm','600mm x 400mm','600mm x 900mm','800mm x 1200mm');
				$mats = array('Labels', 'Corriboard', 'Laminated PVC', 'Laminated Aluminum Composite');
				$products['100mm x 150mm']['Labels'] =  5.30;
				$products['100mm x 150mm']['Corriboard'] = 5.3;
				$products['100mm x 150mm']['Laminated PVC'] = 11.5;
				$products['100mm x 150mm']['Laminated Aluminum Composite'] = 12;
				
				$products['200mm x 300mm']['Labels'] = 6.4;
				$products['200mm x 300mm']['Corriboard'] = 6.4;
				$products['200mm x 300mm']['Laminated PVC'] = 13.8;
				$products['200mm x 300mm']['Laminated Aluminum Composite'] = 14.4;
				
				$products['300mm x 450mm']['Labels'] = 6.9;
				$products['300mm x 450mm']['Corriboard'] = 6.9;
				$products['300mm x 450mm']['Laminated PVC'] = 14.9;
				$products['300mm x 450mm']['Laminated Aluminum Composite'] = 15.6;
				
				$products['400mm x 600mm']['Labels'] = 8.5;
				$products['400mm x 600mm']['Corriboard'] = 8.5;
				$products['400mm x 600mm']['Laminated PVC'] = 18.4;
				$products['400mm x 600mm']['Laminated Aluminum Composite'] = 19.2;
				
				$products['600mm x 400mm']['Labels'] = 8.5;
				$products['600mm x 400mm']['Corriboard'] = 8.5;
				$products['600mm x 400mm']['Laminated PVC'] = 18.4;
				$products['600mm x 400mm']['Laminated Aluminum Composite'] = 19.2;
				
				$products['600mm x 900mm']['Labels'] = 22.1;
				$products['600mm x 900mm']['Corriboard'] = 22.1;
				$products['600mm x 900mm']['Laminated PVC'] = 47.8;
				$products['600mm x 900mm']['Laminated Aluminum Composite'] = 49.9;
				
				$products['800mm x 1200mm']['Labels'] = 34;
				$products['800mm x 1200mm']['Corriboard'] = 34;
				$products['800mm x 1200mm']['Laminated PVC'] = 73.6;
				$products['800mm x 1200mm']['Laminated Aluminum Composite'] = 76.8;
				
			} else if($csv[2] == 2){
				$sizes = array('300mm x 100mm','450mm x 150mm','600mm x 200mm');
				$mats = array('Labels', 'Corriboard', 'PVC', 'Aluminum Composite');
				$products['300mm x 100mm']['Labels'] =  5.5;
				$products['300mm x 100mm']['Corriboard'] = 5.5;
				$products['300mm x 100mm']['PVC'] = 10.4;
				$products['300mm x 100mm']['Aluminum Composite'] = 11;
				
				$products['450mm x 150mm']['Labels'] = 7;
				$products['450mm x 150mm']['Corriboard'] = 7;
				$products['450mm x 150mm']['PVC'] = 13.2;
				$products['450mm x 150mm']['Aluminum Composite'] = 14;
				
				$products['600mm x 200mm']['Labels'] = 7.3;
				$products['600mm x 200mm']['Corriboard'] = 7.3;
				$products['600mm x 200mm']['PVC'] = 13.80;
				$products['600mm x 200mm']['Aluminum Composite'] = 14.6;
				
				
			} else if($csv[2] == 3){
				$sizes = array('75mm x 75mm','100mm x 100mm','150mm x 150mm','200mm x 200mm');
				$mats = array('Labels');
				$products['75mm x 75mm']['Labels'] =  5;
				$products['100mm x 100mm']['Labels'] =5.40;
				$products['150mm x 150mm']['Labels'] = 5.80;
				$products['200mm x 200mm']['Labels'] = 6.20;
			
			} else if($csv[2] == 4){
				$sizes = array('600mm x 400mm');
				$mats = array('Labels', 'Corriboard', 'PVC', 'Aluminum Composite');
				$products['600mm x 400mm']['Labels'] =  8.5;
				$products['600mm x 400mm']['Corriboard'] =8.5;
				$products['600mm x 400mm']['PVC'] = 18.4;
				$products['600mm x 400mm']['Aluminum Composite'] = 19.2;
			}
				
				$s = wp_set_object_terms($new_post_id, $sizes, 'pa_size');
				//var_dump($s);
				//echo '<br>';
				
				$thedata = array('pa_size'=>array(
				'name'=>'pa_size',
				'value'=>'' ,
				'is_visible' => '1', 
				'is_variation' => '1',
				'is_taxonomy' => '1'
				),
				'pa_material'=>array(
				'name'=>'pa_material',
				'value'=>'',
				'is_visible' => '1', 
				'is_variation' => '1',
				'is_taxonomy' => '1'
				)
				);
				update_post_meta( $new_post_id,'_product_attributes',$thedata);
				
				$m = wp_set_object_terms($new_post_id, $mats, 'pa_material');
			//	wp_set_object_terms( $object_id, $terms, $taxonomy, $append);
				//var_dump($m);
				
				//$var_counts = count($mats) * count($sizes);
				
				//insert variations post_type
				$k=1;
				foreach($sizes as $size){
					foreach($mats as $mat){
							$my_post = array(
							  'post_title'    => 'Variation #' . $k . ' of ' . sanitize_title($csv[1]),
							  'post_name'     => 'product-' . $new_post_id . '-variation-' . $k,
							  'post_status'   => 'publish',
							  'post_parent'   => $new_post_id,
							  'post_type'     => 'product_variation',
							  'guid'          =>  home_url() . '/?product_variation=product-' . $new_post_id . '-variation-' . $k
							);
						
							// Insert the post into the database
							$variable_id = wp_insert_post( $my_post );
							do_action( 'woocommerce_create_product_variation', $variation_id );
							
							//wp_set_object_terms($variable_id, $sizes, 'pa_size');
							//update_post_meta( $variable_id,'_product_attributes',$thedata);
							//wp_set_object_terms($variable_id, $mats, 'pa_material');
				
							WC_Product_Variable::sync( $new_post_id );
							
							update_post_meta( $variable_id, 'attribute_pa_size', sanitize_title($size));
							update_post_meta( $variable_id, 'attribute_pa_material',  sanitize_title($mat));
							//update_post_meta( $variable_id, '_price', $products[$size][$mat] );
							update_post_meta( $variable_id, '_regular_price', $products[$size][$mat]);
							do_action( 'woocommerce_api_save_product_variation', $variation_id );					
							$k++;
					}
				}
				//########################## Done adding attributes to product #################
							$transient_name = 'wc_product_children_ids_' . $new_post_id;
							delete_transient( $transient_name );					
				//set product values:
				update_post_meta( $new_post_id, '_stock_status', 'instock');
				//update_post_meta( $new_post_id, '_weight', "0.06" );
				update_post_meta( $new_post_id, '_sku', $csv[0]);
				update_post_meta( $new_post_id, '_stock', "1000" );
				update_post_meta( $new_post_id, '_visibility', 'visible' );
				
				
				//add product image:
					//require_once 'inc/add_pic.php';
					require_once(ABSPATH . 'wp-admin/includes/file.php');
					require_once(ABSPATH . 'wp-admin/includes/media.php');
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					//$thumb_url = $csv[3];
					
					// Download file to temp location
					
					//var_dump($csv[3]);
					$tmp = download_url( $csv[3] );
					// Set variables for storage
					// fix file name for query strings
					preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $csv[3], $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
					//echo '<br>';
					//var_dump( media_handle_sideload( $file_array, $new_post_id, 'gallery desc' ) );
					// If error storing temporarily, unlink
					if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
					}
					
					//use media_handle_sideload to upload img:
					$thumbid = media_handle_sideload( $file_array, $new_post_id, basename($matches[0], '.jpg') );
					//var_dump( is_wp_error($thumbid));
					// If error storing permanently, unlink
					if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);
					//return $thumbid;
					//$logtxt .= "Error: media_handle_sideload error - $thumbid\n";
					}
					//update_post_meta( $new_post_id, '_product_image_gallery', $imgID);
					$set = set_post_thumbnail($new_post_id, $thumbid);
					echo $csv[1].' product imported';
	
			} else  {
				if(isset($exist->ID)){
					echo $csv[1].' product already exists';
				}
			}
		}
					}

				} else {echo 'Sorry file can\'t be uploaded';}
			}
		} else {
  			echo "Sorry, mime type not allowed";
		}
	}
	?>
<form method="post" enctype="multipart/form-data">
Select csv file to import:
    <input type="file" name="importcsv" id="importcsv">
    <input type="submit" value="Import Products" name="submit">
</form>
<?php

}



add_action('admin_init','add_category_once');
function add_category_once(){
	///////////////////// Create Main Category /////////////////////////
	$cats = array(
					array('name' => 'By Type','description' => ' ','slug' => 'by-type'),
					array('name' => 'By Industry','description' => ' ','slug' => 'by-industry'),
				);
		foreach($cats as $data) {
			$cid = wp_insert_term(
				$data['name'], // the term 
				'product_cat', // the taxonomy
				array(
					'description'=> $data['description'],
					'slug' => $data['slug'],
				   // 'parent' => $data['parent']
				)
			);
		}
		
		///////////////////// Create  Sub  Category /////////////////////////
		$sub_cats=array(
						////////////////////////////// Sub cat of Type category ///////////////////////////////
						array('name' => 'Hazard','description' => ' ','slug' => 'hazard','parent'=>"by-type"),
						array('name' => 'Prohibition','description' => ' ','slug' => 'prohibition','parent'=>"by-type"),
						array('name' => 'Mandatory','description' => ' ','slug' => 'mandatory','parent'=>"by-type"),
						array('name' => 'Safe Condition','description' => ' ','slug' => 'safe-condition','parent'=>"by-type"),
						array('name' => 'Fire','description' => ' ','slug' => 'fire','parent'=>"by-type"),
						array('name' => 'Dangerous Goods','description' => ' ','slug' => 'dangerous-goods','parent'=>"by-type"),
						array('name' => 'Vehicle & Parking','description' => ' ','slug' => 'vehicle-parking','parent'=>"by-type"),
						array('name' => 'Waste Management','description' => ' ','slug' => 'waste-management','parent'=>"by-type"),
						array('name' => 'Safety Awareness','description' => ' ','slug' => 'safety-awareness','parent'=>"by-type"),
						array('name' => 'Environmental Awareness','description' => ' ','slug' => 'environmental-awareness','parent'=>"by-type"),
						array('name' => 'Electrical','description' => ' ','slug' => 'electrical','parent'=>"by-type"),
						array('name' => 'Fire & Explosion','description' => ' ','slug' => 'fire-explosion','parent'=>"by-type"),
						array('name' => 'Hazardous Substances','description' => ' ','slug' => 'hazardous-substances','parent'=>"by-type"),
						array('name' => 'Hazardous Areas','description' => ' ','slug' => 'hazardous-areas','parent'=>"by-type"),
						array('name' => 'Slips, Trips & Falls','description' => ' ','slug' => 'slips-rips-falls','parent'=>"by-type"),
						array('name' => 'Machinery & Equipment','description' => ' ','slug' => 'machinery-equipment','parent'=>"by-type"),
						array('name' => 'Access','description' => ' ','slug' => 'access','parent'=>"by-type"),
						array('name' => 'Smoking','description' => ' ','slug' => 'smoking','parent'=>"by-type"),						
						array('name' => 'PPE','description' => ' ','slug' => 'ppe','parent'=>"by-type"),
						array('name' => 'Housekeeping & Hygiene','description' => ' ','slug' => 'housekeeping-hygiene','parent'=>"by-type"),
						array('name' => 'First Aid','description' => ' ','slug' => 'first-aid','parent'=>"by-type"),
						array('name' => 'Exit &  Assembly Point','description' => ' ','slug' => 'exit-assembly-point','parent'=>"by-type"),
						array('name' => 'Water Safety','description' => ' ','slug' => 'water-safety','parent'=>"by-type"),
						array('name' => 'Property & Security','description' => ' ','slug' => 'property-security','parent'=>"by-type"),
						array('name' => 'Child Safety','description' => ' ','slug' => 'child-safety','parent'=>"by-type"),
						array('name' => 'Animal Safety','description' => ' ','slug' => 'animal-safety','parent'=>"by-type"),
						
						////////////////////////////// Sub cat of Type category ///////////////////////////////
						array('name' => 'Construction','description' => ' ','slug' => 'construction','parent'=>"by-industry"),
						array('name' => 'Factory','description' => ' ','slug' => 'factory','parent'=>"by-industry"),
						array('name' => 'Warehouse','description' => ' ','slug' => 'warehouse','parent'=>"by-industry"),
						array('name' => 'Farm & Agribusiness','description' => ' ','slug' => 'safe-condition','parent'=>"by-industry"),
						array('name' => 'Food  & Drinks Industry','description' => ' ','slug' => 'food-drinks_industry','parent'=>"by-industry"),
						array('name' => 'Office','description' => ' ','slug' => 'office','parent'=>"by-industry"),
						array('name' => 'Chemical & Pharmaceutical','description' => ' ','slug' => 'chemical-pharmaceutical','parent'=>"by-industry"),
						array('name' => 'Electronics & Tech','description' => ' ','slug' => 'electronics-tech','parent'=>"by-industry"),
						array('name' => 'Water & Energy Plant','description' => ' ','slug' => 'water-energy-plant','parent'=>"by-industry"),
						array('name' => 'Hospitality & Tourism','description' => ' ','slug' => 'hospitality_tourism','parent'=>"by-industry"),
						array('name' => 'Community & Recreational','description' => ' ','slug' => 'community-recreational','parent'=>"by_industry"),
						array('name' => 'Medical & Healthcare','description' => ' ','slug' => 'medical-healthcare','parent'=>"by-industry"),
						array('name' => 'Retail','description' => ' ','slug' => 'retail','parent'=>"by-industry"),
						array('name' => 'School','description' => ' ','slug' => 'school','parent'=>"by-industry"),
						array('name' => 'Events','description' => ' ','slug' => 'events','parent'=>"by-industry"),
					);
		
					foreach($sub_cats as $data) {
						
						$parent=$category = get_term_by('slug',$data['parent'], 'product_cat');
						$cid = wp_insert_term(
							$data['name'], // the term 
							'product_cat', // the taxonomy
							array(
								'description'=> $data['description'],
								'slug' => $data['slug'],
							   'parent' => $parent->term_id
							)
						);
					}
}