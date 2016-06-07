<?php 
function shape_register_custom_background() {
$args = array(
'default-color' => 'e9e0d1',
);
$args = apply_filters( 'shape_custom_background_args', $args );
if ( function_exists( 'wp_get_theme' ) ) {
add_theme_support( 'custom-background', $args );
} else {
define( 'BACKGROUND_COLOR', $args['default-color'] );
define( 'BACKGROUND_IMAGE', $args['default-image'] );
add_custom_background();
}
}
add_action( 'admin_head', 'change_meta_box_title' );
function change_meta_box_title() {
remove_meta_box( 'postimagediv', 'post_type', 'product' ); //replace post_type from your post type name
add_meta_box('postimagediv', __('Product image'), 'post_thumbnail_meta_box', 'product', 'side', 'low');
}

function  carpetcall_customize($wp_customize){
$wp_customize->add_section('logo' , array(
		'title' => __('Logo', 'carpetcall'),
		'description' => 'Carpetcall logo'
		));
	$wp_customize->add_setting('carpet-logo' , array(
			'default' => 'asset/carpetlogo.png',
		));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'carpet-logo' , array(
		'label' => __('Edit Home Page Image' , 'carpetcall'),
		'section' => 'logo',
		'settings' => 'carpet-logo',
		'extentions'=>array('png','jpeg','gif','jpg')
		)));
}
add_action('customize_register','carpetcall_customize');
/*function carpetcall_sociallinks($wp_customize)
{$wp_customize->add_section('social' , array(
		'title' => __('Social links', 'carpetcall'),
		'description' => 'Fill up the url of social links'
		));
	$wp_customize->add_setting('carpet-social-facebook' , array(
			'default' => 'http://www.facebook.com/carpetcallau',
		));
	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'carpet-social-facebook' , array(
		'label' => __('Facebook link' , 'carpetcall'),
		'section' => 'social',
		'settings' => 'carpet-social-facebook'
		
		)));
	$wp_customize->add_setting('carpet-social-youtube' , array(
			'default' => 'http://www.youtube.com/user/carpetcallau?sub_confirmation=1',
		));
	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'carpet-social-youtube' , array(
		'label' => __('youtube  link' , 'carpetcall'),
		'section' => 'social',
		'settings' => 'carpet-social-youtube'
		
		)));
	$wp_customize->add_setting('carpet-social-pininterest' , array(
			'default' => 'http://www.pinterest.com/carpetcall',
		));
	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'carpet-social-pininterest' , array(
		'label' => __('pininterest  link' , 'carpetcall'),
		'section' => 'social',
		'settings' => 'carpet-social-pininterest'
		
		)));
	$wp_customize->add_setting('carpet-social-googleplus' , array(
			'default' => 'https://plus.google.com/108290827729290320654',
		));
	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'carpet-social-googleplus' , array(
		'label' => __('googleplus  link' , 'carpetcall'),
		'section' => 'social',
		'settings' => 'carpet-social-googleplus'
		
		)));
	
	$wp_customize->add_setting('carpet-social-instagram' , array(
			'default' => 'http://instagram.com/carpetcallau',
		));
	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'carpet-social-instagram' , array(
		'label' => __('instagram  link' , 'carpetcall'),
		'section' => 'social',
		'settings' => 'carpet-social-instagram'
		
		)));
}*/