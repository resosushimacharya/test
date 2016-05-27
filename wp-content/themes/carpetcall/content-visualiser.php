<?php /* HELLO */ 
    $i=0;
 $visarg =array(
  'post_type'=>'visualisers',
   //'orderby' => 'rand',
   'posts_per_page'=>6

    );
 $vis =new WP_Query($visarg);?>
 <div class="container-fluid carpetcall_slide">
        <section class="center slider"><?php 
while($vis->have_posts()):
    $vis->the_post();?><?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
  $caption=get_field('visualiser_caption',$post->ID);
$linku=get_field('visualiser_link',$post->ID);
$linkt=get_field('visuailiser__link_title',$post->ID);
$title=get_field('visualiser_title',$post->ID);
$wobox=get_field('visuailiser_link_title_without_box',$post->ID);
   ?>
   <div>
    <div class="hamro">
    <?php if($title){?>
        <h3> <?php echo $title;?> </h3>
        <?php }?>
        <?php if($caption){?>
        <h4> <?php echo $caption;?> </h4>
        <?php }?>
        <?php if($linkt){?>
        <h5 class="tryit tryita"><a href="<?php echo $linku;?>"> <?php echo $linkt; ?></a></h5>
        
        <?php }?>
        <?php if($wobox) {?>
       <h5 class="tryitwob tryita tryitwob"><a href="<?php echo $linku;?>"> <?php echo $wobox; ?></a></h5> 
       <?php }?>
      </div>
      <img src="<?php echo $feat_image;?>" alt="images" class="img-responsive">
      
    </div>
 <?php 
 endwhile;
 wp_reset_query()?>
 </section>


 <div class="slider_overlay"><img src="<?php echo get_template_directory_uri();?>/images/ajax-loader.gif" style="margin-left:50%;margin-top:5%;"/></div>
       </div><div class="clearfix"></div>
   