<ul class="guide_list_cbg">
            
                    <?php
$term_id_sub = get_queried_object()->term_id;
$term_name   = get_queried_object()->name;
?>
                <?php
$args = array(
    'post_type' => 'buying-guides',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'guide',
            'field' => 'term_id',
            'terms' => $term_id_sub
        )
    )
    
    
);
$loop = new WP_Query($args);
if ($loop->have_posts()):
    while ($loop->have_posts()) {
        $loop->the_post();
        
        $res = get_field('buying_guide_archive', $loop->post->ID);
        
        $i = 0;
        foreach ($res as $rs) {
            $i++;
?>
                     <?php
            echo '<li><a href="' . '#guide_item_' . $i . '">' . $rs['title'] . '<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
?>
                     
                  <?php
        }
    }
    wp_reset_query();
else:
    echo "Post Not Found";
endif;


?>
</ul>
<?php

/**
 *relate the category guide term to prodcut term
 */

$sourcecat = get_queried_object();
$cat_link  = 'halt';
if (get_term_by('slug', $sourcecat->slug, 'product_cat')) {
    $destinationcat = get_term_by('slug', $sourcecat->slug, 'product_cat');
    $cat_link       = get_category_link($destinationcat->term_id);
}
?>
<div class="nowspe nowsppe"><a href="<?php
echo (strcasecmp($cat_link, 'halt') != 0) ? $cat_link : 'javascript:void(0)';
?>"> SHOP NOW </a></div>

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