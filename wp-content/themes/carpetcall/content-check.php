<?php 
/* check */
?>

<div class="col-md-8">
    <?php 
    $i=0;
 $visarg =array(
  'post_type'=>'visualisers',
   'orderby' => 'rand',
   'posts_per_page'=>6

    );
 $vis =new WP_Query($visarg);
while($vis->have_posts()):
    $vis->the_post();?><?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
<?php if($i==1){?>
<div class="row">
<div class="col-md-8">
        <div class="pimg">
        
        <img src="<?php echo $feat_image ;?>" alt="product" class="img-responsive"/>
        <div class="phov"><img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="bg"/> </div>
        <div class="phicn"><a href="<?php echo  get_template_directory_uri();?>/images/product-a.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
        </div></div>
 <?php }?>
 <?php if($i==2){?>
<div class="col-md-4">
        <div class="pimg_b">
        <img src="<?php echo $feat_image ;?>" alt="product" class="img-responsive"/>
        <div class="phov"><img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="bg"/> </div>
        <div class="phicn"><a href="<?php echo  get_template_directory_uri();?>/images/product-b.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i></a> </div>
        </div><div class="clearfix"></div>
 <?php }?>
<?php if($i==3){?>
 <div class="pimg_a">
        <img src="<?php echo $feat_image ;?>" alt="product" class="img-responsive"/>
        <div class="phov"><img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="bg"/> </div>
        <div class="phicn"><a href="<?php echo  get_template_directory_uri();?>/images/product-b.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i></a> </div>
        </div><div class="clearfix"></div>
        
        </div>
 </div><div class="clearfix"></div>
<?php }?>
<?php if($i==4){?>
<div class="belowblk"><div class="row">
    <div class="col-md-4">
    <div class="pimg_a">
        <img src="<?php echo $feat_image ;?>" alt="product" class="img-responsive"/>
        <div class="phov"><img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="bg"/> </div>
        <div class="phicn"> <a href="<?php echo  get_template_directory_uri();?>/images/product-b.jpg"><i class="fa fa-search-plus" aria-hidden="true"></i></a> </div>
        </div>
    </div>

<?php }?>
<?php if($i==5){
    ?>
    <div class="col-md-4">
    <div class="pimg_a">
        <img src="<?php echo $feat_image ;?>" alt="product" class="img-responsive"/>
        <div class="phov"><img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="bg"/> </div>
        <div class="phicn"> <a href="<?php echo  get_template_directory_uri();?>/images/product-b.jpg"><i class="fa fa-search-plus" aria-hidden="true"></i></a> </div>
        </div>
    </div>

<?php }?>
<?php  if($i==6) {?>
<div class="col-md-4">
    <div class="pimg_a">
        <img src="<?php echo $feat_image ;?>" alt="product" class="img-responsive"/>
        <div class="phov"><img src="<?php echo  get_template_directory_uri();?>/images/zbg.png" width="43" height="43" alt="bg"/> </div>
        <div class="phicn"><a href="<?php echo  get_template_directory_uri();?>/images/product-b.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i></a> </div>
        </div>
    </div></div></div><div class="clearfix"></div>
<?php }?>
<?php
$i++;
endwhile;
    ?>
    	
     </div><!-- gallery end -->
     </div>   <?php if($i==1){?> <div class="col-md-8">
       <?php the_title();?>
        <div class="maing_p" style="background:url(slide/carpetcall.jpg) no-repeat; background-size:cover; width:489px; height:268px; overflow:hidden;">
       
            <div class="maing_a"> <img src="images/zbg.png" width="43" height="43" alt="icon"/></div>
             <div class="galsrch galsrchh"> <a href="slide/carpetcall.jpg"><i class="fa fa-search-plus" aria-hidden="true"></i></a></div>
        </div><div class="clearfix"></div><!-- main screen slide -->
        <?php }?>
        <?php if($i==2){?>
        <div class="subgall_blk"><div class="row">
        <div class="col-md-6">
        <div class="gallry_a" style="background:url(slide/carpetcall1.jpg) no-repeat; background-size:cover; overflow:hidden; width:229px; height:139px;">
            <div class="subgal_a"> <img src="images/zbg.png" width="43" height="43" alt="icon"/> </div>
            <div class="subgal_srch subgal_srchh"><a href="slide/carpetcall1.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
        </div>
        </div><!-- like thumbnail one end -->
        
        <?php} ?>
        <?php if($i==3){?>
        <div class="col-md-6">
        <div class="gallry_b" style="background:url(slide/carpetcall2.jpg) no-repeat; background-size:cover; width:229px; height:139px; overflow:hidden;">
        <div class="subgl_a"> <img src="images/zbg.png" width="43" height="43" alt="icon"/> </div>
        <div class="subgl_srch subgl_srchh"><a href="slide/carpetcall2.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
        </div>
        </div><!-- like thumbnail two end -->
        
        </div></div><div class="clearfix"></div>
        
        
       </div><?php } ?><!-- gallery one end -->
       <?php if($i==4){?>
       <div class="col-md-4"> 
       
       <div class="rtgal_blk" style="background:url(slide/carpetcall3.jpg) no-repeat; background-size:cover; width:230px; height:129px; overflow:hidden;">
        <div class="subrtg_a"> <img src="images/zbg.png" width="43" height="43" alt="icon"/> </div>
        <div class="subrtg_srh subrtg_srhh"><a href="slide/carpetcall3.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
       </div><div class="clearfix"></div><!-- like thumbnail three end -->
       <?php }?>
       <?php if($i==5){?>
       <div class="rtgal_blk_a" style="background:url(slide/carpetcall4.jpg) no-repeat; background-size:cover; width:230px; height:129px; overflow:hidden;">
       <div class="subrtg_b"> <img src="images/zbg.png" width="43" height="43" alt="icon"/> </div>
       <div class="subrtbb_srh subrtbb_srhh"><a href="slide/carpetcall4.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
       </div><div class="clearfix"></div><!-- like thumbnail four end -->
       <?php }?>
       <?php if($i==6){?>
       <div class="rtsec_blk_b" style="background:url(slide/carpetcall5.jpg) no-repeat; background-size:cover; width:230px; height:141px; overflow:hidden;">
        <div class="rtsec_bb"> <img src="images/zbg.png" width="43" height="43" alt="icon"/> </div>
        <div class="rtsec_srch rtsec_srchh"><a href="slide/carpetcall5.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
       </div><div class="clearfix"></div><!-- like thumbnail five end -->
       
       
       </div>
       <?php }?>

     <?php $i++;
     }?>