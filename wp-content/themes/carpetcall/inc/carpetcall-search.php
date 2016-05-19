<?php 

add_action( 'init', 'myprefix_autocomplete_init' );
function myprefix_autocomplete_init() {
    // Register our jQuery UI style and our custom javascript file
    wp_register_style('myprefix-jquery-ui','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
    wp_register_script( 'my_acsearch', get_template_directory_uri() . '/js/carpetcall-search.js', array('jquery','jquery-ui-autocomplete'),null,true);
 
    // Function to fire whenever search form is displayed
    add_action( 'get_search_form', 'myprefix_autocomplete_search_form' );
    wp_localize_script( 'my_acsearch', 'MyAcSearch', array('url' => admin_url( 'admin-ajax.php' )));
 
    // Functions to deal with the AJAX request - one for logged in users, the other for non-logged in users.
    add_action( 'wp_ajax_myprefix_autocompletesearch', 'carpetcall_searchform' );
    add_action( 'wp_ajax_nopriv_myprefix_autocompletesearch', 'carpetcall_searchform' );
}
function myprefix_autocomplete_search_form(){
    wp_enqueue_script( 'my_acsearch' );
    wp_enqueue_style( 'myprefix-jquery-ui' );
}
function carpetcall_searchform(){
    // Query for suggestions
    $posts = get_posts( array(
        's' =>$_REQUEST['term'],
    ) );
 
    // Initialise suggestions array
    $suggestions=array();
 
    global $post;
    foreach ($posts as $post): setup_postdata($post);
        // Initialise suggestion array
        $suggestion = array();
        $suggestion['label'] = esc_html($post->post_title);
        $suggestion['link'] = get_permalink();
 
        // Add suggestion to suggestions array
        $suggestions[]= $suggestion;
    endforeach;
 
    // JSON encode and echo
    $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
    echo $response;
 
    // Don't forget to exit!
    exit;
}