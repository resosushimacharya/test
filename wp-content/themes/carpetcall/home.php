
<?php /* Template Name: design */
    get_header();
    get_template_part('content', 'visualiser');
    get_template_part('content', 'headings');?>

<div class="container">
        <div class="calbk">
                <div class="row">
    
                        <div class="col-sm-3">
                                
                                <div class="cpt_supt">
                                        <img src="<?php echo get_template_directory_uri();?>/images/carpetcall-support-img.png" alt="support" class="img-responsive"/> 

                                </div>

                        </div>

                        <div class="col-sm-5">
                                <h3 class="bookcbk"><?php echo get_field('home_contact_heading', 'option'); ?></h3>
                                <h4 class="cptspl"><?php echo get_field('contact_sub_heading', 'option'); ?></h4>
                                <div class="suptlst">
                                        <?php $booklink = get_field('contactlink', 89); ?>
                                        <ul>
                                        <?php foreach ($booklink as $singlelink) {

                                                      echo '<li> ' . $singlelink['ask_an_expert'] . '</li>';
                                            } ?>


                                        </ul>
                                </div>
                                <div class="clearfix"></div>
                        </div><!-- support text end -->

                        <div class="col-sm-4">
                                <div class="cptin cptinn">
                                        <a href="<?php echo get_field('contact_url', '89');?>"> <?php echo get_field('contact_link_title', '89');?></a>
                                </div>
                        </div><!-- contact end -->
                </div>
        </div>
</div>
<div class="clearfix"></div><!-- contact us end here -->
    
<div class="feature_pro">
        <div class="container">
                <div class="row">
                        <div class="meropro_blk">
                                <h1> <?php echo get_field('home_product_heading', 'option');?> </h1>

                                <div class="col-md-12 no-lr">

                                <div class="responsive">
                                <!-- product six end  -->
                                <?php
                                get_template_part('content', 'featured');
                                ?>

                                </div><div class="clearfix"></div>

                                </div><div class="clearfix"></div>

                        </div>
                </div><div class="clearfix"></div>
        </div>
        <div class="featured_overlay">
                <img src="<?php echo get_template_directory_uri();?>/images/ajax-loader.gif" style="margin-left:50%;margin-top:12%;"/>
        </div>
</div>
<div class="clearfix"></div><!-- featured product end here -->
<!--ideas and advice strats here -->
<?php get_template_part('content', 'idea'); ?>
<!-- ideas and advice end here -->
<!-- trade starts here -->
<?php get_template_part('content', 'expert'); ?>        
<!-- trade end here -->

<?php get_template_part('content', 'carpetmap'); ?><!-- about and visit content end here -->

<?php get_footer(); ?>
   
   
