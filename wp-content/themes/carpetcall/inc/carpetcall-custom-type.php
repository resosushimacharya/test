<?php 
function custom_post_type()
	{

get_arguments('expert','experts','Expert','Experts','Experts');

get_arguments('FAQ','FAQS','FAQ','FAQS','FAQS');
get_arguments('Guide','Guides','Guide','Guides','Guides');
get_arguments('Slider','Sliders','Slider','Sliders','Sliders');
}
function get_arguments($singular,$plural,$singular_name,$menu_name,$name){
		$labels = array(
		'name' => _x($name, 'Post Type General Name', 'text_domain') ,
		'singular_name' => _x($singular_name, 'Post Type Singular Name', 'text_domain') ,
		'menu_name' => __($menu_name, 'text_domain') ,
		'parent_item_colon' => __('Parent '.$singular_name.':', 'text_domain') ,
		'all_items' => __('All '.$menu_name, 'text_domain') ,
		'view_item' => __('View '.$singular_name, 'text_domain') ,
		'add_new_item' => __('Add New '.$singular_name, 'text_domain') ,
		'add_new' => __('New '.$singular_name, 'text_domain') ,
		'edit_item' => __('Edit '.$singular_name, 'text_domain') ,
		'update_item' => __('Update '.$singular_name, 'text_domain') ,
		'search_items' => __('Search '.$singular_name, 'text_domain') ,
		'not_found' => __('Not found', 'text_domain') ,
		'not_found_in_trash' => __('Not found in Trash', 'text_domain') ,
	);
	$args = apply_filters($singular.'_post_type_args',array(
		'label' => __('event', 'text_domain') ,
		'description' => __('Product information pages', 'text_domain') ,
		'labels' => $labels,
		'supports' => array(
			'title',
			'editor',
			
			
			'thumbnail',
		
			// 'permalink',
'excerpt' ,
		
			'revisions',
		
			'page-attributes',
			'post-formats',
			'tag',
			'category'
			
		) ,
'taxonomies'          => array(  'post_tag' ),
'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-id',
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'query_var' => true
	));
	register_post_type($plural, $args);
	flush_rewrite_rules();
}
	add_action('init', 'custom_post_type',0);
	