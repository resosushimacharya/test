<?php get_header(); ?>
<div class="child-innerpg">
    <div class="container clearfix">
        <div class="inerblock_serc_child about-page">
            <div class="cc-breadcrumb">
              <span class="cc-bread-current"><?php the_title(); ?></span>
            </div><!-- end .cc-breadcrumb -->
            <h1><?php the_title(); ?></h1>
        </div><!-- end .innerblock_serc_child -->
    </div><!-- end .container.clearfix -->
</div><!-- end .child-innerpg -->

<div class="faq-cont-blka">
    <div class="container clearfix">
        <div class="inerblock_sec">
            

            <div class="col-md-12">
                <div class="cbg_content">
                    <?php 
                        the_content();
                    ?>
                </div><!-- end .cbg_content -->
            </div><!-- end .col-md-9 -->

        </div><!--end .innerblock_sec -->
    </div><!-- end .container.clearfix -->
</div><!-- end .faq-cont-blka -->

<?php get_footer(); ?>