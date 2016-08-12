<?php
/*
**Template Name: Ideas and Advice child page
**
*/
 get_header();
?>
<div class="child-innerpg">
<div class="container clearfix">
<div class="inerblock_serc_child">
<?php
//$parent_title = get_the_title($post->post_parent);
/*echo $parent_title;*/
?>
<?php if(empty( $post->post_parent)): ?>
<?php 
if(have_posts()):

    while(have_posts()):
      the_post();

       the_title();

       the_content();

    endwhile;


	else:
		echo "not found";


	endif;

?>
<?php else: ?>
	<?php get_template_part('content','second');?>
<?php endif;?>	
</div>
</div>
</div>
<div class="clearfix"></div>
 <script>
        jQuery(document).ready(function($) {
    $('ul.guide_list_cbg li a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top - 155
        }, 900, 'swing', function () {
            window.location.hash = target;
        } );
    } );
} );

    </script>

 <?php get_footer();


 ?>