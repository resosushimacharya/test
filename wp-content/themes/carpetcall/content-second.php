 <?php 
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  $bgID = 1690;
  $proID = 1711; 
  $faqID = 1725;
  $rugID = 1700;
  $hardID = 1234;
}
else{
  $bgID = 26696;
  $proID = 26709; 
  $faqID = 26721;
  $rugID = 26701;
  $hardID = 26703;
}


 ?><div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>

</div>


<h3><span class="ab_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></span><?php echo get_the_title();?> <?php echo get_the_title($post->post_parent);?> </h3>
  
           
</div>
</div>
</div>
<!-- content section -->
<div class="faq-cont-blka">
 <div class="container clearfix">
	<div class="inerblock_sec">
		<div class="col-md-3 no-pl">
        <div class="meromm">
			<ul class="guide_list_cbg">


<?php 
 $res = get_field('buying_guide_archive', get_the_id());
  if($post->post_parent!=$faqID){ ?>
<?php 

        
        $i = 0;
        foreach ($res as $rs) {
            $i++;
?>
                     <?php
            echo '<li><a href="' . '#guide_item_' . $i . '">' . $rs['title'] . '<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
?>
                     
                  <?php
        }
 }
 else{

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

 }
 ?>
</ul>

<?php 
if($post->ID==$rugID || $post->ID==$hardID){
?>
<!-- here comes certain contains in future if neaded..  -->
<div class="nowspe nowsppe"><a href="<?php
echo (strcasecmp($cat_link, 'halt') != 0) ? $cat_link : 'javascript:void(0)';
?>"> SHOP NOW </a></div>
<?php }?>

            </div>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-9">
			<div class="cbg_content">
     <?php if($post->post_parent!=$faqID){ ?>

 <?php
			  $i = 0; foreach($res as $rs){
                  	$i++;?>
                      <h3 id="<?php echo "guide_item_".$i; ?>"><?php echo $rs['title'];?></h3>
                      <p> <?php echo $rs['description'];?></p>
                  <?php  } 
              }
            ?>
            <?php 
if($post->post_parent==$faqID){?>
	        <div class="cont-panl">
			<div class="panel-group" id="accordion">

					
			
					<?php  $i = 0; foreach($res as $rs){
                  	$i++;?>
                      
                  
					<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>">
          <span class="pull-right glyphicon <?php echo ($i==1)?'glyphicon-chevron-up':'glyphicon glyphicon-chevron-down'?>"></span>
          <?php echo $rs['title'];?>
        </a>
      </h4>
    </div>
    <div id="collapse_<?php echo $i;?>" class="panel-collapse collapse <?php echo ($i==1)?'in':'' ;?> ">
      <div class="panel-body">
        <?php echo $rs['description'];?>
      </div>
    </div>
  </div>
				

            
            <?php  } ?>
<?php }
?>
</div></div>
             </div>
		</div>
</div>
</div>
</div>

	<div class="inerblock_sec_a">

    <div class="container clearfix you_may_link_cntr">
        <h3 style="text-align:center">YOU MAY ALSO LIKE</h3>



<?php
$tax = 'product_cat';
 ?><?php
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'product',
					
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'ignore_sticky_posts'=> 1
					);
					//echo $tax_term->slug;
					$my_query = null;
					$my_query = new WP_Query($args);
					while ($my_query->have_posts()) : $my_query->the_post();
					$woo=get_post_meta($post->ID);
					
					$price=$woo['_regular_price'][0];
					
					
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					
					/*if(!empty(unserialize($woo['_product_attributes'][0])))
				$prounits=unserialize($woo['_product_attributes'][0]);*/
				
				if(isset($prounits['size']['value'])){
					$prounit=$prounits['size']['value'];
				}
               ?>
                     <?php  if($woo['_featured'][0]=='yes'){ ?>
                   <div class="col-md-4">
                  		<div class="pro_secone">
                  		<div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div>
                  
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="mero_itemss">
                      		<div class="proabtxt">
					<h4><?php
					the_title();?></h4><?php 

					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					

					

					
					if(!empty($price)){
						echo '<h5> FROM A$'.$price.'</h5>';
						
						}?></div>
					<div class="clearfix"></div>
                           
                      </div>
                      </div>
                      </div>
                      <?php }?>
					
               <?php

					endwhile;
					wp_reset_query();
					?><div class="clearfix"></div>
					
                    
    </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
    $('ul.guide_list_cbg li a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top - 185
        }, 900, 'swing', function () {
            window.location.hash = target;
        } );
    } );
} );
jQuery(window).load(function() {

    $('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-up").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
});

});
    </script>
<?php 
get_footer();
?>