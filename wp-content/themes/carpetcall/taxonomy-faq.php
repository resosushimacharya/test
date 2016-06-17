<?php get_header();

?>
<?php
$tax = 'faq';

$link = rtrim($_SERVER['REQUEST_URI'],'/');
$link =ltrim($link,'/');
$linkarr= explode('/',$link);
$len = count($linkarr);
$termname= $linkarr[$len-1];
echo $termname;

 ?>
	<div class="container clearfix">
<div class="inerblock_sec_faq">
					
					
					 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>

</div>
<h3><span class="ab_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i> Carepet faqs</span></h3>

</div>

</div><!-- step one end -->

		<div class="faq-cont-blka">
		<div class="container clearfix">

			<div class="col-md-3 no-pl">
<div class="meromm">
			<?php get_sidebar('faqterm');?>
            </div><div class="clearfix"></div>
		</div>
        
			<div class="col-md-9">
            <div class="cont-panl">
			<div class="panel-group" id="accordion">

					<?php while(have_posts()):
the_post();
the_title();
the_content();

endwhile;
?>
					<?php
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'faqs',
					"$tax" => $termname,
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'ignore_sticky_posts'=> 1
					);
					//echo $tax_term->slug;
					 $faqcounter = 1;
					$my_query = null;
					$my_query = new WP_Query($args);
					while ($my_query->have_posts()) : $my_query->the_post();
					
					?>

                   
                    
					<?php 

					//$reqTempTerms=get_the_terms($post->ID,$tax);
					      ?>
					      
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $faqcounter;?>">
          <span class="pull-right glyphicon <?php echo ($faqcounter==1)?'glyphicon-chevron-up':'glyphicon glyphicon-chevron-down'?>"></span>
          <?php echo the_title();?>
        </a>
      </h4>
    </div>
    <div id="collapse_<?php echo $faqcounter;?>" class="panel-collapse collapse <?php echo ($faqcounter==1)?'in':'' ;?> ">
      <div class="panel-body">
        <?php the_content();?>
      </div>
    </div>
  </div>
		
				
					
               <?php
                       $faqcounter++;
					endwhile;
					wp_reset_query();
					?>
					
				</div>
            </div>
            </div>
                
        </div>  
		</div><div class="clearfix"></div><!-- step two end here -->


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
    </div><!-- step three end here --------->
                    
                    
                    
<script type="text/javascript">
	$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-up").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
});
</script>
<?php 
get_footer();
?>
 