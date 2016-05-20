<?php //hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'callCustomTaxonomy', 0 );

//create a custom taxonomy name it $plural for your posts

function callCustomTaxonomy()
{

   
create_dynamic_hierarchical_taxonomy('profaq','profaqs','faqs','Faqcategory','faq');
create_dynamic_hierarchical_taxonomy('Guide','Guides','Guides','Gudiecategory','guide');

}


function create_dynamic_hierarchical_taxonomy($singular,$plural,$posttype,$cat,$catreg) {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( $cat, 'taxonomy general name' ),
    'singular_name' => _x( $singular, 'taxonomy singular name' ),
    'search_items' =>  __( 'Search '. $plural ),
    'all_items' => __( 'All '. $plural ),
    'parent_item' => __( 'Parent '.$singular ),
    'parent_item_colon' => __( 'Parent '.$singular.':' ),
    'edit_item' => __( 'Edit '. $cat ), 
    'update_item' => __( 'Update '. $singular ),
    'add_new_item' => __( 'Add New '. $cat),
    'new_item_name' => __( 'New '.$singular .'Name' ),
    'menu_name' => __( $cat ),
  ); 	

// Now register the taxonomy

  register_taxonomy($catreg,array($posttype), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => $cat ),
  ));

}

