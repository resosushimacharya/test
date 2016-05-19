<?php
$tax = 'profaqs';
 ?><div class="container">
					<div class="row">
					<div class="col-md-12">
					<ul>
					<?php
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'faqs',
					
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
						   
						  
						 
						  	echo '<li>'.$reqTerm->name.'</li>';
						  	echo '<a href="'.get_term_link($reqTerm).'">'.$reqTerm->name.'</a>';
					}
					
					?>
					
				
					
               <?php

					endwhile;
					wp_reset_query();
					?>
					</ul>
					</div></div></div>