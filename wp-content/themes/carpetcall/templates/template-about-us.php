<?php
/*
    Template Name: About Us Pages
*/
get_header();

/*
    * local and staging may have different IDs
    * get About Us page ID
    * need to show left navigation for About Us
*/
$url = site_url();
$url = explode('/',$url);
if( strcasecmp($url[2],'localhost')==0 ) { 
    $aboutID    = 317;
    $children   = array( 2314 , 2307 );
}
else { 
    $aboutID =317;
    $children   = array( 33774 , 33763 );
}

/*
    * code for : breadcrumb
        * find ancestors ( for sub pages )
        * if ancestors exist , build breadcrumb
        * else show single-level breadcrumb
*/
$id = get_the_id();
$ancestors = get_post_ancestors( $id );
#print_r( $ancestors );
#exit;
// reverse array to maintain correct ancestor order
$ancestors = array_reverse ( $ancestors );
$size      = count( $ancestors );
?>
<div class="child-innerpg">
    <div class="container clearfix">
        <div class="inerblock_serc_child about-page">
            <div class="cc-breadcrumb">
                <?php 
                    if( !empty( $ancestors ) ) {
                        for( $i=0; $i<=$size; $i++ ) {
                            $class = ( $i == 0 ) ? 'cc-bread-root' : 'cc-bread-parent';

                            if( $i == $size ) $class = 'cc-bread-current';

                            if( $i>0 ) echo ' > ' ;
                ?>
                    <span class="<?php echo $class; ?>">
                        <?php if ( $i == $size ) { echo get_the_title(); } 
                              else { 
                        ?>
                            <a href="<?php echo get_the_permalink( $ancestors[$i] );?>"><?php echo get_the_title( $ancestors[$i] );?> </a>
                        <?php } #end-else ?>
                    </span>
                <?php

                        } #end-for
                    } else {
                ?>                        
                    <span class="cc-bread-current"><?php the_title(); ?></span>
                <?php } #end-else ?>
            </div><!-- end .cc-breadcrumb -->
            <h1><?php the_title(); ?></h1>
        </div><!-- end .innerblock_serc_child -->
    </div><!-- end .container.clearfix -->
</div><!-- end .child-innerpg -->

<div class="faq-cont-blka">
    <div class="container clearfix">
        <div class="inerblock_sec">
            <div class="col-md-3 no-pl">
            <?php
                // show top-level navigation for About Us page
                if( $size == 1 || $aboutID == $id) {
            ?>
                <div class="meromm">
                    <ul class="guide_list_cbg">
                        <?php
                            $ancestor_id = (!empty( $ancestors )) ? $ancestors[0] : $id;
                            $all_about_pages = array(
                                'child_of'      => $ancestor_id,
                                #'include'      => $children,
                                'depth'         => 1,
                                'sort_column'   => 'menu_order',
                                'link_after'    => '<i class="fa fa-caret-right" aria-hidden="true"></i>',
                                'title_li'      => ''
                            );
                            wp_list_pages( $all_about_pages );
                        ?>                        
                    </ul><!-- end .guide_list_cbg -->
                </div><!-- end .meromm -->
            <?php } #end-if 

                // show inner-page navigation
                else {
            ?>
                <div class="meromm">
                    <ul class="guide_list_cbg">
                        <?php
                            $ancestor_id = (!empty( $ancestors )) ? $ancestors[$size-1] : $id;
                            $all_about_pages = array(
                                'child_of'  => $ancestor_id ,
                                'depth'     => 1,
                                'link_after'=> '<i class="fa fa-caret-right" aria-hidden="true"></i>',
                                'title_li'  => ''
                            );
                            wp_list_pages( $all_about_pages );
                        ?>                        
                    </ul><!-- end .guide_list_cbg -->
                </div><!-- end .meromm -->
            <?php } #end-if ?>
                <div class="clearfix"></div>
            </div><!-- end .col-md-3.no-pl -->

            <div class="col-md-9">
                <div class="cbg_content">
                    <?php the_content(); ?>
                </div><!-- end .cbg_content -->
            </div><!-- end .col-md-9 -->

        </div><!--end .innerblock_sec -->
    </div><!-- end .container.clearfix -->
</div><!-- end .faq-cont-blka -->

<?php get_footer(); ?>