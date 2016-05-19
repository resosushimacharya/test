<?php
get_header();?>
<p>You searched for " <?php echo esc_html( get_search_query( false ) ); ?> ". Here are the results:</p><?php
if(have_postS()):
while(have_posts()):
the_post();
$title = get_the_title();
$contant=get_the_content();
$keys= explode(" ",$s);
$title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title);?>
<a href="<?php the_permalink(); ?>"><p>Click the button to get your coordinates.</p>


	<?php
	if(has_post_thumbnail())
	{
		the_post_thumbnail();
	}
	echo $title;
	the_content();
	endwhile;
	else:
	echo "no post found";
	endif;
	get_footer();
	?>