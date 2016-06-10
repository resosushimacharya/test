<?php $args = array(
	'name'          => __( 'Guide Category', 'Carpetcall' ),
	'id'            => 'guide category list',
	'description'   => '',
        'class'         => '',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>' ); ?>
	<?php  register_sidebar( $args ); ?>