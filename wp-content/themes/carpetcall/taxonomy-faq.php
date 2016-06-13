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

 ?><div class="container clearfix">
<div class="inerblock_serc">
					<ul>
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
					$my_query = null;
					$my_query = new WP_Query($args);
					while ($my_query->have_posts()) : $my_query->the_post();
					
					?>

                   
                    
					<?php 

					$reqTempTerms=get_the_terms($post->ID,$tax);
					       
					
					foreach($reqTempTerms as $reqTerm){ 
						  
						  if(strcasecmp($reqTerm->name,$termname)==0){?>
						  <?php 	//echo '<li>'.$reqTerm->name.'</li>';
						  	
						  
						  	the_title();
						  	the_content();?>
						  	<a href="<?php the_permalink();?>">click here</a>
						  	<?php }
					}
					
					?>
					
				
					
               <?php

					endwhile;
					wp_reset_query();
					?>
					</ul>
				</div>
</div><div class="clearfix"></div><link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<div class="container">
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <span class="glyphicon glyphicon-minus"></span>
          Collapsible Group Item #1
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          <span class="glyphicon glyphicon-plus pull-right"></span>
          Collapsible Group Item #2
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          <span class="glyphicon glyphicon-plus"></span>
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
</div>
<?php 
get_footer();
?>