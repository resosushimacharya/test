<div class="col-md-8">
    <div class="row">
    <div class="ourgallery">
    	<?php 
    $i=0;
 $visarg =array(
  'post_type'=>'visualisers',
   'orderby' => 'rand',
   'posts_per_page'=>6

    );
 $vis =new WP_Query($visarg);
while($vis->have_posts()):
    $vis->the_post();?><?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
  $i++;?>
      <?php if($i==1){?> <div class="col-md-8">
       
       	<div class="maing_p" style="background:url(<?php echo $feat_image;?>) no-repeat; background-size:cover; width:auto; height:268px; overflow:hidden;">
       
        	<div class="maing_a"> <img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="icon"/></div>
             <div class="galsrch galsrchh"> <a href="<?php echo $feat_image;?>"><i class="fa fa-search-plus" aria-hidden="true"></i></a></div>
        </div><div class="clearfix"></div><!-- main screen slide -->
          <?php }?>
          <?php if($i==2){ ?>
        <div class="subgall_blk"><div class="row">
        <div class="col-md-6">
        <div class="gallry_a" style="background:url(<?php echo $feat_image;?>) no-repeat; background-size:cover; overflow:hidden; height:139px;">
        	<div class="subgal_a"> <img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="icon"/> </div>
            <div class="subgal_srch subgal_srchh"><a href="<?php echo get_template_directory_uri().'/slide/';?>carpetcall1.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
        </div>
        </div><!-- like thumbnail one end -->
        <?php }?>
         <?php if($i==3){?>
        <div class="col-md-6">
        <div class="gallry_b" style="background:url(<?php echo $feat_image;?>) no-repeat; background-size:cover; height:139px; overflow:hidden;">
        <div class="subgl_a"> <img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="icon"/> </div>
        <div class="subgl_srch subgl_srchh"><a href="<?php echo get_template_directory_uri().'/slide/';?>carpetcall2.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
        </div>
        </div><!-- like thumbnail two end -->
        
        </div></div><div class="clearfix"></div>
        
        
       </div><?php }?><!-- gallery one end -->
        <?php if($i==4){?>
       <div class="col-md-4"> 
       
       <div class="rtgal_blk" style="background:url(<?php echo $feat_image;?>) no-repeat; background-size:cover; height:129px; overflow:hidden;">
       	<div class="subrtg_a"> <img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="icon"/> </div>
        <div class="subrtg_srh subrtg_srhh"><a href="<?php echo get_template_directory_uri().'/slide/';?>carpetcall3.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
       </div><div class="clearfix"></div><!-- like thumbnail three end -->
       <?php }?>
       <?php if($i==5){?>
       <div class="rtgal_blk_a" style="background:url(<?php echo $feat_image;?>) no-repeat; background-size:cover;  height:129px; overflow:hidden;">
       <div class="subrtg_b"> <img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="icon"/> </div>
       <div class="subrtbb_srh subrtbb_srhh"><a href="<?php echo get_template_directory_uri().'/slide/';?>carpetcall4.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
       </div><div class="clearfix"></div><!-- like thumbnail four end -->
       <?php }?>
       <?php if($i==6){?>
       <div class="rtsec_blk_b" style="background:url(<?php echo $feat_image;?>) no-repeat; background-size:cover;  height:141px; overflow:hidden;">
       	<div class="rtsec_bb"> <img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="icon"/> </div>
        <div class="rtsec_srch rtsec_srchh"><a href="<?php echo get_template_directory_uri().'/slide/';?>carpetcall5.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
       </div><div class="clearfix"></div><!-- like thumbnail five end -->
       
       
       </div><div class="clearfix"></div><!-- gallery two end -->
      <?php }
      endwhile;
      wp_reset_query();?>
    </div>
    </div>
    </div><!-- gallery end -->