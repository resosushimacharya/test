<div class="inerblock_sec_a">
  <div class="container clearfix you_may_link_cntr">
    <h3 class="cc-idea-ad-title" style="text-align:center">IDEAS & ADVICE</h3>
       <div class="you_may_like-content">
   <?php  

     
$listcat=get_the_terms($post->ID,'product_cat');
if($listcat){
foreach($listcat as $cat){
  if($cat->parent==0){
    //echo "that's the correct answer";
    $root = $cat->slug;
    $rootname = $cat->name;
    if(strcasecmp($root,"hard-flooring")==0){
      $root ="hard-flooring";
    }
  }
  else{
    //echo "that's the bullshit answer";
  }
}
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'name' => $root

 );

$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    $faqid =$post->ID;
   
    //parent ID ;
    $feat_image =wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'medium' );
    if($feat_image){
      $feat_image = $feat_image[0];
      }
      else{
        $feat_image =get_template_directory_uri().'/images/placeholder.png';
      }
    $post_data = get_post($parent->post->post_parent);
   $parent_name =  $post_data->post_name; ?>
   
   <div class="col-md-4">
        <div class="pro_secone_a"> <a href="<?php echo get_the_permalink($post->ID);?>">
          <div class="img_cntr_a" style="background-image:url('<?php echo $feat_image; ?>');"></div>
          </a>
          <div class="mero_itemss">
            <div class="proabtxt"> <a href="<?php echo get_the_permalink($post->ID);?>">
            <?php if(strcasecmp($parent_name,'buying-guides')==0){

              echo '<h4>BUYING GUIDE</h4>';
              }
              elseif(strcasecmp($parent_name,'faqs')==0){

               echo  "<h4>FAQ'S</h4>";
             }
              else{
                       echo "<h4>PRODUCT CARE</h4>";
              }

              ?>
              <span><?php echo get_the_title($post->ID) ;?> </span></a> </div>
            
            <div class="clearfix"></div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
   <?php 

    

}
}?>
  </div>


  
    <div class="clearfix"></div>
  </div>
</div>