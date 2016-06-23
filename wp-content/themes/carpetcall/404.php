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
    wp_redirect (site_url() );
    exit;
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
  ?>
<div class="container">
	<div class="error-section row")>
	    <div class="error-wrapper " style="background-image:url(<?php echo $error_wrapper['url'];?>);">   
	    
	    			 <h1 class="error-title"><?php echo $error_title;?></h1>
			 <h3 class="error-info"><?php echo $error_info;?></h3>	
			 <h4 class="error-prob"><?php echo $error_prob;?></h4>
             <div class="col-md-12">
			<button class="error-red-link" ><a href="<?php echo $oldlink; ?>">GO BACK</a></button>
		</div>
		</div>
		
		
	</div>
</div>
 <style>
 .error-section{
 	margin:150px 0 38px 0;

 }
 .error-wrapper{
     
    float: right;
    
    min-width: 100%;
    min-height: 156px;
    height:auto;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    overflow: hidden;
}
 .error-wrapper{
 	color:#000000;
 }
 .error-wrapper h1{
 	font-size:50px;
 	text-transform: uppercase;
 }
 .error-wrapper h3{
 	color:#0000ff;
 	font-size:32px;
 	text-transform: uppercase;
 	text-decoration: none;
 	border:none;

 }
 .error-wrapper  h4{
 	font-size:28px;
 	text-transform: uppercase;

 }
 .error-red-link{
 	text-align:center;
 }



 </style>

<?php
get_footer();
?>