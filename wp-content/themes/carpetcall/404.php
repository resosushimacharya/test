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

<div class="container clearfix">
	<div class="error-section row">
	    <div class="error-wrapper">   
			 <h1 class="error-title">404</h1>
			 <h3 class="error-info">Sorry, the page you requestedcannot be bispalyed </h3>	
			 <h4 class="error-prob">We may have accidentally swept it under the rug  </h4>

		</div>
		
		<div class="">
			<button><a href="<?php echo $oldlink; ?>">GO BACK</a></button>
		</div>
	</div>
</div>
 <style>
 .error-section{
 	margin:150px 0 38px 0;
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

 </style>

<?php
get_footer();
?>