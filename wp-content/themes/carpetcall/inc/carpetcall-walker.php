<?php class JC_Walker_Nav_Menu extends Walker_Nav_Menu {
function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
{
// check, whether there are children for the given ID and append it to the element with a (new) ID
$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);
return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
}
	
	// add classes to ul sub-menus
function start_lvl( &$output, $depth = 0, $args = array() ) {
// depth dependent classes
$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
$display_depth = ( $depth + 1); // because it counts the first submenu as 0
$classes = array(
'sub-menu',
( $display_depth % 2 ? 'menu-odd  small-menu' : 'menu-even' ),
( $display_depth >=2 ? 'sub-sub-menu ' : '' ),
'menu-depth-' . $display_depth
);
$class_names = implode( ' ', $classes );

// build html
$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
}

// add main/sub classes to li's and links
function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
global $wp_query;
$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

if($args->walker->has_children )
{
$depth_classes = array(
( $depth == 0 ? 'main-menu-item has-sub' : 'sub-menu-item ' ),
( $depth >=2 ? 'sub-sub-menu-item' : '' ),
( $depth % 2 ? 'menu-item-odd has-sub' : 'menu-item-even has-sub' ),
'menu-item-depth-' . $depth
);
}
else{
$depth_classes = array(
( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
( $depth >=2 ? 'sub-sub-menu-item' : '' ),
( $depth % 2 ? 'menu-item-odd ' : 'menu-item-even' ),
'menu-item-depth-' . $depth
);
}
$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

// passed classes
$classes = empty( $item->classes ) ? array() : (array) $item->classes;
$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

// build html
$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	
	// link attributes
	$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link ' : 'main-menu-link ' ) . '"';
	
		
		
		if($depth >=2){
			$item_outputs= ( $args->walker->has_children) ? ' %1$s<a%2$s>%3$s%4$s%5$s<span>%6$s</span></a>' :'%1$s<a%2$s><span> <i class="fa fa-caret-right menu-style-sub" aria-hidden="true"></i>%3$s%4$s%5$s</span></a>%6$s';
		}
		else
		{
		$item_outputs= ( $args->walker->has_children) ? ' %1$s<a%2$s>%3$s%4$s%5$s<span>%6$s</span></a>' :'%1$s<a%2$s>%3$s%4$s%5$s%6$s</a>';
	}
		
	$item_output = sprintf($item_outputs,
	$args->before,
	$attributes,
	$args->link_before,
	apply_filters( 'the_title', $item->title, $item->ID ),
	$args->link_after,
	$args->after
	);
	
	// build html
	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
	
	}}
	
class JC_Footer_Nav_Menu extends Walker_Nav_Menu {
function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
{
// check, whether there are children for the given ID and append it to the element with a (new) ID
$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);
return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
}
	
	// add classes to ul sub-menus
function start_lvl( &$output, $depth = 0, $args = array() ) {
// depth dependent classes
$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
$display_depth = ( $depth + 1); // because it counts the first submenu as 0
$classes = array(
'sub-menu',
( $display_depth % 2 ? 'menu-odd  carptfot' : 'menu-even ' ),
( $display_depth >=2 ? 'sub-sub-menu ' : '' ),
'menu-depth-' . $display_depth
);
$class_names = implode( ' ', $classes );


// build html
$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
}

// add main/sub classes to li's and links
function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
global $wp_query;
$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

if($args->walker->has_children )
{
$depth_classes = array(
( $depth == 0 ? 'main-menu-item col-md-3  sourblk  ' : 'sub-menu-item' ),
( $depth >=2 ? 'sub-sub-menu-item' : '' ),
( $depth % 2 ? 'menu-item-odd xyz col-md-3' : 'menu-item-even xy sourblk  ' ),
'menu-item-depth-' . $depth
);
}
else{
	//sub-menu-item  menu-item-odd  menu-item-depth-1 menu-item
$depth_classes = array(
( $depth == 0 ? 'main-menu-item col-md-3' : 'sub-menu-item' ),
( $depth >=2 ? 'sub-sub-menu-item' : '' ),
( $depth % 2 ? 'menu-item-odd  ' : 'menu-item-even ' ),
'menu-item-depth-' . $depth
);
}
$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

// passed classes


$classes = empty( $item->classes ) ? array() : (array) $item->classes;
$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

// build html
$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	
	// link attributes
	$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	//$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link ' : 'main-menu-link ' ) . '"';
	
		
		
		if($depth >=2){
			$item_outputs= ( $args->walker->has_children) ? ' %1$s<a%2$s><span class="sourblk">%3$s%4$s%5$s</span></a>%6$' :'%1$s<a%2$s><span class="sourblk">%3$s%4$s%5$s</span></a>%3$s%4$s%5$s%6$s';
		}
		else
		{
		$item_outputs= ( $args->walker->has_children || $depth==0) ? ' %1$s<a%2$s><span class="sourblk">%3$s%4$s%5$s</span></a>%6$' :'%1$s&nbsp<a%2$s>%3$s%4$s%5$s%6$s</a>';
	}
		
	$item_output = sprintf($item_outputs,
	$args->before,
	$attributes,
	$args->link_before,
	apply_filters( 'the_title', $item->title, $item->ID ),
	$args->link_after,
	$args->after
	);
	
	// build html
	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
	
	}}