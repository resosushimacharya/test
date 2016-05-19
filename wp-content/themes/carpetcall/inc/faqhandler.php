<?php //hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'callCustomTaxonomy', 0 );

//create a custom taxonomy name it $plural for your posts

function callCustomTaxonomy()
{

   
create_dynamic_hierarchical_taxonomy('profaq','profaqs','faqs');

}


function create_dynamic_hierarchical_taxonomy($singular,$plural,$posttype) {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( $plural, 'taxonomy general name' ),
    'singular_name' => _x( $singular, 'taxonomy singular name' ),
    'search_items' =>  __( 'Search'. $plural ),
    'all_items' => __( 'All'. $plural ),
    'parent_item' => __( 'Parent'.$singular ),
    'parent_item_colon' => __( 'Parent'.$singular.':' ),
    'edit_item' => __( 'Edit'. $singular ), 
    'update_item' => __( 'Update'. $singular ),
    'add_new_item' => __( 'Add New'. $singular),
    'new_item_name' => __( 'New '.$singular .'Name' ),
    'menu_name' => __( $plural ),
  ); 	

// Now register the taxonomy

  register_taxonomy($plural,array($posttype), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => $singular ),
  ));

}

