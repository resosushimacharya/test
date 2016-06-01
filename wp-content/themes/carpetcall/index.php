<?php get_header();?>



<div class="container clearfix">
<div class="inerblock_serc">
<?php 
if(have_posts()):
while(have_posts()):
    the_post();

the_title();
the_content();
echo '<a href="'.the_permalink().'">readmore'.'</a>';
    
endwhile;
else:
    echo 'page not found';

endif;?>
</div>
</div><div class="clearfix"></div>

<?php 
get_footer();

?>