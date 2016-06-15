<?php
/**
* @package carpetcall
* @subpackage carpetcall
*/
//show_admin_bar(false );


update_option('siteurl',"http://localhost/carpetcall");
update_option('home',"http://localhost/carpetcall");

add_action('pr','inspect_carpetcall',10,1);
function inspect_carpetcall($arg)
{
echo '<pre>';
       print_r($arg);
  echo '</pre>';
}
/*do_action('pr',$_POST);
die();*/
include_once TEMPLATEPATH."/inc/carpetcall-script.php";
remove_filter ('acf_the_content', 'wpautop');

//include_once TEMPLATEPATH."/inc/carpetcall-search.php";
add_theme_support( 'post-thumbnails' );
function register_my_menus() {
  global $wp_taxonomies;
$store_categories = $wp_taxonomies['wpsl_store_category']->labels;
$store_categories->name = 'Store States';
$store_categories->singular_name = 'Store State';
$store_categories->search_items = 'Search Store States';
$store_categories->all_items = 'All Store States';
$store_categories->parent_item = 'Parent Store State';
$store_categories->parent_item_colon = 'Parent Store State';
$store_categories->edit_item = 'Edit Store State';
$store_categories->view_item = 'View State';
$store_categories->update_item = 'Update Store State';
$store_categories->add_new_item = 'Add New Store State';
$store_categories->new_item_name = 'New Store State Name';
$store_categories->not_found = 'No states found.';
$store_categories->no_terms = 'No states';
$store_categories->items_list_navigation = 'States list navigation';
$store_categories->items_list = 'States list';
$store_categories->menu_name = 'Store States';
$store_categories->name_admin_bar = 'Store State';
$store_categories->archives = 'All Store States';
register_nav_menus(
array(
'header-menu' => __( 'Header Menu' ),
'front-menu' => __( 'Front Menu' ),
'footer-menu' => __( 'Footer Menu' )
)
);
}
add_action( 'init', 'register_my_menus' );
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','articles','nav_menu_item');
    $query->set('post_type','wpsl_stores');
	return $query;
    }
}

/*<form>
                <div class="input-group">
  <input type="text" class="form-control" aria-label="Product" placeholder="TYPE TO SEARCH" >
  <span class="input-group-addon"><i class="fa fa-search fa-2x" aria-hidden="true"></i></span>
</div>
</form>*/

function carpet_search_form( $form ) {
  $serch_tt=get_search_query();
	 if(empty($serch_tt)){
	 	$mysearch="TYPE TO SEARCH";
	 }
	 else $mysearch=get_search_query();

    $form = '<form role="search" method="get" id="" class="" action="' . home_url( '/' ) . '" >
   
    <div class="input-group">
    <input type="text" class="form-control" aria-label="Product" placeholder="' . $mysearch. '" name="s" id="s" />
    <span class="input-group-btn">
    <button type="submit" class="btn btn-default" id="searchsubmit" value="" />
	<img src="'.get_template_directory_uri().'/images/magnify.png" alt="icon" width="22" height="22"/> 
    </button>
    </span>

    </div>
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'carpet_search_form' );
include_once TEMPLATEPATH."/inc/carpetcall-custom-type.php";

include_once TEMPLATEPATH."/inc/faqhandler.php";

function pr($x){
	echo '<pre>'.$x.'</pre>';
}
include_once TEMPLATEPATH."/inc/carpetcall-customizer.php";
include_once TEMPLATEPATH."/inc/carpetcall-woocommerce.php";
/*include_once TEMPLATEPATH."/inc/backcsv.php";*/
/* shoping cart section */
function filter_search($query) {
if ($query->is_search) {
$query->set('post_type', array('backgrounds','product','workflows','visualiser','post'));
};
return $query;
};
add_filter('pre_get_posts', 'filter_search');

include_once TEMPLATEPATH."/inc/carpetcall-walker.php";
include_once TEMPLATEPATH."/inc/carpetcall-storefinder.php";
include_once TEMPLATEPATH."/inc/register-sidebar-admin.php";
	


class MyNewWidget extends WP_Widget {

  function __construct() {
    // Instantiate the parent object
    parent::__construct( false, 'My New Widget Title' );
  }

  function widget( $args, $instance ) {?>
  <input type="text" class="widefat"  />
 <?php }

  function update( $new_instance, $old_instance ) {
    // Save widget options
  }

  function form( $instance ) {
    // Output admin widget options form
  }
}

function myplugin_register_widgets() {
  register_widget( 'MyNewWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );
if (!class_exists('catPostdisplay')) {

class catPostdisplay extends WP_Widget {
  
   function __construct() {
    global $control_ops, $post_cat, $post_num, $post_length;  

    $widget_ops = array(            
            'classname' => 'Guide-Widget', 
            'description' => __( 'Dispalys Related Category Posts', 'Carpetcall') 
            );
    
    /*$this->WP_Widget('catPostdisplay', __('Category Posts', 'Sajha-Khabar'), $widget_ops, $control_ops);*/
    parent::__construct( false, 'Guide Widget Title',  $widget_ops,$control_ops );
  } 
  
  function widget($args, $instance){

    extract($args); do_action('pr',$args);  
    do_action('pr',$instance);      
    $mycategory       =  isset( $instance['guide'] ) ? $instance['guide'] : '';
    $number_ofposts       =  isset( $instance['number_ofposts'] ) ? $instance['number_ofposts'] : '3';
    if($number_ofposts==0)
    {
       $number_ofposts=3;
    }
    elseif($number_ofposts<0)
    {
      $number_ofposts= ceil(0-$number_ofposts);
    }
    else
    {
      $number_ofposts=ceil($number_ofposts);

    }
    echo $args['before_widget'];
    ?>  
 
  <!-- main front end area todisplay -->
                  

              <div class="sidebar-widget">
                            <div class="hot_news">
                                <h3 class="news-header"><?php echo $mycategory ; $mycatid=get_cat_id($mycategory);?></h3>
                                <div class="newsinfo-detail">
                                  <?php  echo ctype_digit($number_ofposts)  ;?>
                                    <ul>
                                    <?php 
                  $args=array('posts_per_page'=>$number_ofposts,'cat'=>$mycatid,'order'=>'DESC');
                                    $query = new WP_Query($args);
                                    if($query->have_posts()) :while ($query->have_posts()) : $query->the_post();
                                    ?>
                                        <li><a href="<?php the_permalink(); ?>"> <?php the_title() ;?></a></li>
                                     <?php
                                     endwhile; endif;
                                     wp_reset_query();
                                     ?>
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>




  <!-- end of displaying area -->   
  <?php
  echo $args['before_widget'];
  } 
    
  function form($instance){ 
    
    $instance = wp_parse_args( (array) $instance, array(
            'mycategory'      => 'carpet',  
            
            ) 
          );
    
    
    $mycategory           =  isset( $instance['mycategory'] ) ? $instance['mycategory'] : '';
    $number_ofposts       =  isset( $instance['number_ofposts'] ) ? $instance['number_ofposts'] : '';
    if($number_ofposts==0)
    {
       $number_ofposts=3;
    }
    elseif($number_ofposts<0)
    {
      $number_ofposts= ceil(0-$number_ofposts);
    }
    else
    {
      $number_ofposts=ceil($number_ofposts);

    }
    
    ?>


    <p>
    <label for="<?php echo $this->get_field_name('mycategory'); ?>">
    <?php _e('Choose your Category', 'Sajha-Khabar'); ?>:  </label>
    <select class="widefat" name="<?php echo $this->get_field_name('mycategory'); ?>" > 

    <?php 
         $cat_args=array(
        'orderby' => 'name',
        'order' => 'ASC'
         );

     $categories =  get_categories($cat_args); 
     foreach ( $categories as $category ) {
     ?>

    <option value="<?php echo $category->name ; ?>" <?php if($category->name  == $mycategory){ echo 'selected="selected"';} ?>> <?php echo $category->name ; ?></option>

    <?php 
     }
     ?>

    </select> 
    </p>



    <p>
    <label for="<?php echo $this->get_field_name('number_ofposts'); ?>">
    <?php _e('No. of posts to Display', 'Sajha-Khabar'); ?>:  </label>
    <input type="number" class="widefat" name="<?php echo $this->get_field_name('number_ofposts'); ?>" value="<?php echo $number_ofposts ?>" >
    </p>



    <?php   
  
  } //end of form
  
  function update($new_instance, $old_instance){

    $instance               = $old_instance;
    $instance['mycategory']       = $new_instance['mycategory'];  
    $instance['number_ofposts']     = $new_instance['number_ofposts'];    
    
    return $instance;
  }
    
  }// END class
  
  
  function catPostdisplay_init() {
    register_widget('catPostdisplay');
  } 
  add_action('widgets_init', 'catPostdisplay_init');

}
class TutsplusText_Widget extends WP_Widget {
 
    public function __construct() {
     
        parent::__construct(
            'tutsplustext_widget',
            __( 'TutsPlus Text Widget', 'Carpetcall' ),
            array(
                'classname'   => 'tutsplustext_widget',
                'description' => __( 'A basic text widget to demo the Tutsplus series on creating your own widgets.', 'Carpetcall' )
                )
        );
       
       /* load_plugin_textdomain( 'Carpetcall', false, basename( dirname( __FILE__ ) ) . '/languages' );*/
       
    }
 
    /**  
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {    
         
        extract( $args );
         
        $title      = apply_filters( 'widget_title', $instance['title'] );
        $message    = $instance['message'];
         
        echo $before_widget;
         
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
                             
        echo $message;
        echo $after_widget;
         
    }
 
  
    /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
    public function update( $new_instance, $old_instance ) {        
         
        $instance = $old_instance;
         
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['message'] = strip_tags( $new_instance['message'] );
         
        return $instance;
         
    }
  
    /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
    public function form( $instance ) {    
     
        $title      = (isset($instance['title']))?esc_attr( $instance['title'] ):'';
        $message    = (isset($instance['message']))?esc_attr( $instance['message'] ):'';
        ?>
         
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple Message'); ?></label> 
            <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>"><?php echo $message; ?></textarea>
        </p>
     
    <?php 
    }
     
}
 
/* Register the widget */
add_action( 'widgets_init', function(){
     register_widget( 'TutsplusText_Widget' );
});



/*
  * filtering WP Store Locator
  * removing fields 'address2' and 'state' from Location
  * removing fields 'email' and 'url' from Additional Information
*/
add_filter( 'wpsl_meta_box_fields', 'custom_meta_box_fields' );
function custom_meta_box_fields( $meta_fields ) {
    // check for compatibility - delete if only exists ; may need to change code on plugin upgrade
    // don't show fields not in use
  
    if( isset( $meta_fields['Location']['address2'] ))
      unset($meta_fields['Location']['address2']);
    
    if( isset( $meta_fields['Location']['state'] ) ) 
      unset($meta_fields['Location']['state']);

    if( isset( $meta_fields['Additional Information']['email'] ) ) 
      unset($meta_fields['Additional Information']['email']);
      
    if( isset( $meta_fields['Additional Information']['url'] ) ) 
      unset($meta_fields['Additional Information']['url']);  

    return $meta_fields;
}
