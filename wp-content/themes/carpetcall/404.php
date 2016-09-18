<?php 
/**
*this page is for error page
*will direct into home page 
*once user will input wroong url 
*/
?>
<?php 

$oldlink = null;
if(empty($_SERVER['HTTP_REFERER'] )) {
   /* wp_redirect (site_url() );
    exit;*/
}
else{
	$oldlink = $_SERVER['HTTP_REFERER'];
}
?>
<?php

get_header();

?>

 <?php
 	   $error_title = get_field('error_title','option');
 	   $error_info =  get_field('error_description','option');
 	   $error_prob =  get_field('error_additional_description','option');
 	   $error_wrapper = get_field('background_image','option');
 	   //do_action('pr',$error_wrapper);
  ?><div class="body-wrapper">

<div class="page-sorry clearfix" style="background-image:url(<?php echo $error_wrapper['url'];?>);">
<div class="container">
	    <div class="error-wrapper">   
	    
	    			 <h1 class="error-title"><?php echo $error_title;?></h1>
			 <h3 class="error-info"><?php echo $error_info;?></h3>	
			 <h4 class="error-prob"><?php echo $error_prob; ?></h4>
			 <?php if($oldlink!=null){?>
             <div class="col-md-12">
			<button class="error-red-link" ><a href="<?php echo $oldlink; ?>">GO BACK</a></button>
		</div>
		<?php }
		else{
			?>
			   <div class="col-md-12">
			<button class="error-red-link" ><a href="<?php echo site_url();?>">GO TO HOMEPAGE</a></button>
		</div>
			<?php } ?>
		</div>
		
</div>
</div>

</div>


<?php
get_footer();
?>