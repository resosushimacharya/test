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
</div><div class="clearfix"></div>
<?php 
get_footer();
?>