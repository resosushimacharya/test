<?php
/**
* The template for displaying the header
*
* Displays all of the head element and everything up until the "site-content" div.
*
* @package carpetcall
* @subpackage carpetcall
*/
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		
		<title><?php bloginfo('title');?>|<?php echo bloginfo('description');?></title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<a href="<?php echo site_url(); ?>"><img src="<?php echo get_theme_mod('carpet-logo');?>"/></a>;
		<div><ul>
			<?php
				echo '<li><a href="'.get_theme_mod('carpet-social-facebook').'"
					target="_balnk"
				>facebook</a></li>';
				echo '<li><a href="'.get_theme_mod('carpet-social-youtube').'"
					target="_balnk"
				>youtube</a></li>';
				echo '<li><a href="'.get_theme_mod('carpet-social-pininterest').'"
					target="_balnk"
				>pininterest</a></li>';
				echo '<li><a href="'.get_theme_mod('carpet-social-googleplus').'"
					target="_balnk"
				>googleplus</a></li>';
				echo '<li><a href="'.get_theme_mod('carpet-social-instagram').'">googleplus</a></li>';
			?>
			
		</ul>	<?php get_search_form ( );
		?>
	</div>
	<?php
	$headnav= array( 'theme_location' => 'header-menu' );
	wp_nav_menu($headernav); ?>
	<?php echo "this is for front menu";
	$frontnav= array( 'theme_location' => 'header-menu' );
	wp_nav_menu($frontnav); ?>
	<?php //$footernav= array( 'theme_location' => 'header-menu' );
	//wp_nav_menu($footernav); ?>