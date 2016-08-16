<?php /* HELLO */ 
    $i=0;
 $visarg =array(
  'post_type'=>'sliders',
   //'orderby' => 'rand',
   'posts_per_page'=>6

    );
 $vis =new WP_Query($visarg);?>
 <div class="container-fluid carpetcall_slide">
        <section class="center slider"><?php 
while($vis->have_posts()):
    $vis->the_post();?><?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
  

$slider_title=get_field('slider_title',$post->ID);
$slider_caption=get_field('slider_caption',$post->ID);
$slider_link_title=get_field('slider_link_title',$post->ID);
$slider_link_title_without_box=get_field('slider_link_title_without_box',$post->ID);
$slider_link=get_field('slider_link',$post->ID);
$slider_external_link=get_field('slider_external_link',$post->ID);
   ?>
   <div>
    <div class="hamro">
    <?php if($slider_title){?>
        <h3> <?php echo $slider_title;?> </h3>
        <?php }?>
        <?php if($slider_caption){?>
        <h4> <?php echo $slider_caption;?> </h4>
        <?php }?>
       
        <?php if($slider_link_title_without_box) {?>
       <h5 class="tryitwob tryita tryitwob"><a href="<?php echo($slider_external_link!=null?$slider_external_link:$slider_link);?>" target="_blank"> 
       <?php echo $slider_link_title_without_box; ?></a></h5> 
       <?php }
       else{?>
 <?php if($slider_link_title){?>
        <h5 class="tryit tryita"><a href="<?php echo ($slider_external_link!=null?$slider_external_link:$slider_link);?> "target="_blank"> <?php echo $slider_link_title; ?></a></h5>
        
        <?php }?>
       <?php  }?>
      </div>
      <img src="<?php echo $feat_image;?>" alt="images" class="img-responsive">
      
    </div>
 <?php 
 endwhile;
 wp_reset_query()?>
 </section>


 <div class="slider_overlay"><img src="<?php echo get_template_directory_uri();?>/images/ajax-loader.gif"/></div>
       </div><div class="clearfix"></div>
   