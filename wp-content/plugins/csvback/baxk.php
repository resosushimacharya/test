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

function css_products_import()
{
	echo '<h1>CSV Import</h1>';
 
	

  if(isset($_POST['submit']) && ($_POST['submit']=="updating"))
	{ 
		
		cron_func_update();
     /*   $args = array(

                "post_type"=>'product',
                "post_status"=>array("publish"),
                "posts_per_page"=>"-1",
                'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => array("hard-flooring","rugs")
                                )
                            )
            );
        $loop = new WP_Query($args);

        $i  = 1;echo "Draft Product List : <br />";
        while($loop->have_posts()){
            $loop->the_post();
            the_title();
            echo "<br />";
            
            wp_delete_post($loop->post->ID, true );
        }
    
        wp_reset_query();*/
	}   
	
	?>
<div class="container" class="import_csv_container">
	<form method="post" class="import_csv_form">
		<h2 for="">Select CSV file to import:</h2>

     	<button type="submit" value="updating" name="submit">Update products </button>
     </form>
</div>
<?php

}
?>