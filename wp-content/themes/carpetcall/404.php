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
			 <h4 class="error-prob"><?php echo $error_prob;?></h4>
			 <?php if($oldlink!=null){?>
             <div class="col-md-12">
			<button class="error-red-link" ><a href="<?php echo $oldlink; ?>">GO BACK</a></button>
		</div>
		<?php }?>
		</div>
		
</div>
</div>

</div>
 <style>
 .body-wrapper{
 	margin:145px 0 38px 0;

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
	 font:bold 72px 'proxima_nova_ltsemibold', sans-serif;
	 color:#15489f;
 	text-transform: uppercase;
	margin-top:75px;
	margin-left:24px;
 }
 .error-wrapper h3{
 	font:normal 24px 'proxima_nova_ltsemibold', sans-serif;
	 color:#15489f;
 	text-transform: uppercase;
	margin-top:-8px;
	margin-left:24px;
 }
 .error-wrapper  h4{
 	font:normal 18px 'proxima_nova_ltsemibold', sans-serif;
	 color:#0099ff;
 	text-transform: uppercase;
	margin-top:3px;
	margin-left:24px;
	margin-bottom:48px;
 }
 .page-sorry .error-wrapper button { background-color:#FFF; padding:0; margin-left:9px; margin-bottom:101px; }
.page-sorry .error-wrapper button a{
	display:inline-block;
 	background-color:#FFF;
	border:1px solid #15489f;
	padding:11px 128px;
	border-radius:0;
	outline:0;
	text-transform:uppercase;
	font-size:18px;
	text-align:center;
	color:#15489f;
	text-decoration:none;
 }
 .page-sorry .error-wrapper button a:hover { background-color:#15489f; color:#FFF;}



 </style>

<?php
get_footer();
?>