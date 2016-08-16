<div class="trade"><!-- trade section start here -->
        <div class="container">
                <div class="hamro_trade">
                        <h2><?php echo get_field('home_expert_heading','option') ;?> </h2>
                        <div class="row">
                                <?php if( !have_rows( 'experts_section' , 'option' ) ) {?>
                                <div class="col-md-12">
                                        <p class="text-center"><?php _e( 'Nothing has been set for this section !' , 'carpetcall' ); ?></p>
                                </div>
                                <?php } 
                                else { 
                                        $i=0;
                                        while( have_rows( 'experts_section' , 'option' ) ) {
                                                        the_row();
                                                        $title          = get_sub_field( 'highlight') . ' ' . get_sub_field( 'non_highlight_section' );
                                                        $link_selected  = get_sub_field( 'link_url_external' ); // check for external link
                                                        $content        = apply_filters( 'the_content' , get_sub_field( 'content' ) );
                                                        ?>
                                                        <div class="col-md-6 idea-<?php ( $i%2==0 ) ? 'left' : 'right'; ?>">
                                                                <div class="measure_blk">
                                                                        <div class="meas_img">
                                                                                <img src="<?php the_sub_field('featured_image'); ?>" alt="<?php echo $title; ?>" class="img-responsive">
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div class="measr_cnt">
                                                                                <h3>
                                                                                <?php
                                                                                if( get_sub_field( 'highlight' ) ) echo '<span class="frcol"> ' . get_sub_field( 'highlight') . ' </span>';
                                                                                if( get_sub_field( 'non_highlight_section') ) echo get_sub_field( 'non_highlight_section' );
                                                                                ?>
                                                                                </h3>
                                                                                <p><?php echo $content; ?></p>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <?php
                                                                        $link       = get_sub_field( 'link' );
                                                                        $link_title = get_sub_field( 'link_title' );
                                                                        if( $link && $link_title ) {
                                                                        ?>
                                                                        <div class="find_tb find_tbb">
                                                                                <a href="<?php echo $link; ?>" title="<?php echo $title; ?>"<?php if( is_array( $link_selected ) ) echo 'target="_blank"' ; ?>>  <?php echo $link_title; ?> </a>
                                                                        </div>
                                                                        <?php } #end-if ?>
                                                                        <div class="clearfix"></div>
                                                                </div>
                                                        </div>
                                <?php
                                     $i++;
                                        } #end-while
                                } #end-else
                                ?>
                        </div><!-- end .row -->
                        <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
        </div>
</div>
<div class="clearfix"></div>