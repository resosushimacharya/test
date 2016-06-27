<?php 
/*
**category page for product care
**
*/

get_header()
?>
<?php $term_id =  get_queried_object()->term_id;
$currentcat = get_queried_object();
$tax = 'product_care';
$termname=get_queried_object()->name;

?>
<div class="body-wrapper inerblock_sec_faq">
	<div class="container">
	 	<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
   			 <?php if(function_exists('bcn_display'))
    			{
        			bcn_display();
   			    }?>

    	</div>
		<h3>
			<span class="ab_arrow">
				<i class="fa fa-angle-left" aria-hidden="true"></i> <?php echo $termname;?> Product Care
			</span>
		</h3>

	</div>
</div>
<div class="container">

    
    
<div class="tophead_sec col-md-12 no-lr">

<div class="faq-cont-blka">
		<div class="container clearfix">

			<div class="col-md-3 no-pl">
<div class="meromm">
			<?php get_sidebar('product-care');?>
            </div><div class="clearfix"></div>
		</div>
        
			<div class="col-md-9">
            <div class="cont-panl">
			<div class="panel-group" id="accordion">
        
					
					<?php
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'product_cares',
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
</div>
</div>
<!-- css part will be included in carpetcall-style.css -->
<style>
.body-wrapper{
		margin:150px 0 38px 0;
}
</style>

<?php get_footer();
?>
