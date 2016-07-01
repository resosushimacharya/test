<?php
/* 
** Template Name: Visit Store
*/
?>
<?php get_header();?>



<div class="cbg_blk cc-clearance-blk clearfix">
 <div class="container ">
<div class="inerblock_serc cc-wrapper-whole">
<div class="col-md-6">					
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display')){
        bcn_display();
    }?>

</div>
<h3><?php echo  get_the_title();?></h3>
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#find_your_nearest_store">FIND YOUR NEAREST STORE</a></li>
  <li><a data-toggle="tab" href="#head_offices">HEAD OFFICES</a></li>
  
</ul>

<div class="tab-content">
  <div id="find_your_nearest_store" class="tab-pane fade in active">
    <h3>HOME</h3>
    <p><?php echo do_shortcode('[wpsl]');?></p>
  </div>
  <div id="head_offices" class="tab-pane fade">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
  </div>
  
</div>


</div>

</div>
</div>
</div>
<style>
.cc-wrapper-blk{
background:#f0f2f1 !important;
}
.cc-wrapper-whole h3{
	text-decoration:none !important;
	border:none;

}
.cc-contact-side{
	
}
.cc-form-wrapper{
	padding:5px;
}
</style>
<?php 
get_footer();

?>