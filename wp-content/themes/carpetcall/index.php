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

endif;
$posts = get_posts('post_type=wpsl_stores&wpsl_store_category=tas'); 
$count = count($posts); 
echo $count; 
?>
</div>
</div><div class="clearfix"></div>

<?php 
get_footer();

?>