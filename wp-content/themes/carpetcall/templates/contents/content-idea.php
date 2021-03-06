<?php
        $url = site_url();
        $url =explode('/',$url);
        if(strcasecmp($url[2],'localhost')==0){
                $bgID = 1690;
                $proID = 1711;
                $faqID = 1725;
        }
        else{
                $bgID = 26696;
                $proID = 26709;
                $faqID = 26721;
        } ?>
<div class="container">
        <div class="thought_blk">
                <h2>  <?php echo get_field('home_ideas_and_advice_heading','option') ;?> </h2>
                <div class="row">
                <?php 
                        $guides=get_field('ideas_and_advice_section','option');
                        $gi= 2 ;
                        $external_link = null;
                        foreach($guides as $guide):?>
                                <div class="col-md-6  <?php echo ($gi%2==0?'idea-left':'idea-right') ;?>">

                                        <div class="idea-top_block <?php echo ($gi%2==0?'rmvisual':'care_pro') ;?>" style="background-image:url(<?php echo $guide['image']['url'];?>);">
                                        <?php
                                                if(!empty($guide['link_url_external'])){
                                                        $external_link =$guide['link_url_external'][0];
                                                }
                                                else
                                                {
                                                        $external_link = null;

                                                }

                                        ?>
                                                <div class="rmblk_cont">
                                                        <h3> <?php  echo $guide['title'];?></h3>
                                                        <p> <?php  echo $guide['description'];?></p>
                                                        <div class="trynow trynoww">
                                                                <a href="<?php echo $guide['link_url']; ?>" <?php if($external_link!=null){ echo 'target = "_blank"';} ?>>
                                                                <?php  echo $guide['link_title']; ?> </a>
                                                                <i class="fa fa-angle-right" aria-hidden="true"></i> 
                                                        </div>
                                                        <div class="clearfix"></div>
                                                </div>
                                        </div>
                                        <div class="clearfix"></div>

                                </div>
                        <?php 
                                $gi++;
                        endforeach; ?>


                </div>
                <div class="clearfix"></div>

                <div class="row">

                        <div class="col-md-6 idea-left">
                                <div class="idea-bottom_block guide_a" style="background-image:url(<?php echo get_template_directory_uri().'/images/guides.png';?>); ">


                                        <div class="inner_cont">
                                                <h4> BUYING GUIDES  </h4>

                                                <ul class="guide_list">
                                                <?php

                                                        $args = array(
                                                                'post_type'      => 'page',
                                                                'posts_per_page' => -1,
                                                                'post_parent'    => $bgID ,
                                                                'order'          => 'ASC',
                                                                'orderby'        => 'menu_order'
                                                        );

                                                        $parent = new WP_Query( $args );
                                                        while($parent->have_posts()){
                                                                $parent->the_post();

                                                                echo '<li><a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
                                                        }
                                                        wp_reset_query();
                                                ?>
                                                </ul>
                                                <div class="clearfix"></div>

                                        </div><!-- end here --><!-- testing phase end -->

                                </div>
                                <div class="clearfix"></div><!-- guide end here -->
                        </div>

                        <div class="col-md-6 idea-right">
                                <div class="idea-bottom_block faq_blk" style="background-image:url(<?php echo get_template_directory_uri().'/images/faq.png';?>);">


                                        <div class="quest_cont">
                                                <h4> FAQ'S </h4>
                                                <ul class="guide_list">

                                                <?php

                                                $args = array(
                                                'post_type'      => 'page',
                                                'posts_per_page' => -1,
                                                'post_parent'    => $faqID,
                                                'order'          => 'ASC',
                                                'orderby'        => 'menu_order'
                                                );
                                                $parent = new WP_Query( $args );
                                                while($parent->have_posts()){
                                                        $parent->the_post();

                                                        echo '<li><a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
                                                }
                                                wp_reset_query();
                                                ?>
                                                </ul>
                                        <div class="clearfix"></div>

                                        </div>

                                </div><div class="clearfix"></div><!-- faq end here -->
                        </div>

                </div>
                <div class="clearfix"></div>

        </div>
        <div class="clearfix"></div>
</div>
<div class="clearfix"></div>