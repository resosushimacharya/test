<?php 
/*
**Template Name: Ideas and Advice inner page
**
*/ get_header();
/**
  * Template tag for breadcrumbs.
  *
  * @param string $before  What to show before the breadcrum
  * @param string $after   What to show after the breadcrumb.
  * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
  * @return string
  */
 $term_id_sub =  get_queried_object()->term_id;
 $term_name = get_queried_object()->name;
?>
 <div class="cbg_blk clearfix">
 <div class="container">
<div class="inerblock_serc">
					
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>

</div>

<h1><span class="ab_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></span><?php echo get_the_title();?>  </h1>
</div>
</div>
</div>


 <div class="container clearfix">
	<div class="inerblock_sec">
		<div class="col-md-3 no-pl">
        <div class="meromm">
			<?php get_sidebar('guide');?>
            </div>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-9">
			<div class="cbg_content">
             <?php while(have_posts()){
             	the_post();
             	?>
           
             
             		<?php the_content();?>
             	
            <?php  }
            wp_reset_query();?>


             </div>
		</div>
</div>
</div>
    <script>
        jQuery(document).ready(function($) {
    $('ul.guide_list_cbg li a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top - 185
        }, 900, 'swing', function () {
            window.location.hash = target;
        } );
    } );
} );

    </script>
<?php 
get_footer();
?>
<!-- dsahfl -->
