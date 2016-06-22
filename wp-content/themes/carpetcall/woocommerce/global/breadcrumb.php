<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;
       $i=1;
       global $len; 
       $len =count($breadcrumb);
       $seclast = $len-1;
       global $appafter;
       $appafter='';
      
	foreach ( $breadcrumb as $key => $crumb ) {
  
		echo $before;
		if($len>4){
        if(($i!=1) && ($i!=$len)){
        	if($i==2){
        		
        	}
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '" class="breadcrum-link-'.$i.'">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;
		if($i!=$seclast){

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}
	}
	$i++;
}
else{

if(($i!=1)){
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			if($i==$seclast && $len==4){
			 $appafter = esc_html( $crumb[0] ); 

			}
			echo '<a href="' . esc_url( $crumb[1] ) . '" class="breadcrum-link-'.$i.'">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] ).' '.'<span class="cc-product-term">'.$appafter.'</span>';
		}

		echo $after;
		

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	
	}
	$i++;

}

	}


	echo $wrap_after;

}

