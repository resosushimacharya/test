<?php
get_header();?>
<div class="container">
<?php if(!esc_html( get_search_query( false ) )){
	echo "You have not serach any thing ...";
}
else{?>
    <p>You searched for "
        <?php echo esc_html( get_search_query( false ) ); ?> ". Here are the results:</p>
    <?php
wp_reset_query();
$flag= 1;
if(have_posts()):
while(have_posts()):
the_post();
$title = get_the_title();
$contant=get_the_content();
$keys= explode(" ",$s);
if(!empty($s)){
$flag = 0;
$title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title);?>
        <a href="<?php the_permalink(); ?>">
            <p>Click the button to get your coordinates.</p>
            <?php
if(has_post_thumbnail())
{
	the_post_thumbnail();
}
echo $title;
the_content();
}
endwhile;
else:
	if($flag == 1){echo '"Sorry we can not seem to find what you are looking for"';}

endif;
}?>
</div>
<?php get_footer();
?>