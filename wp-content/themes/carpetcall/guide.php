<?php 
/* Template Name: guide */
 get_header();
 ?>

<div class="container clearfix">
	<div class="inerblock_serc">
		<div class="col-md-2">
			<ul class="guide_list " style="color:black;">
            
					<?php
                            $tax = 'guide'; 
						$tax_terms = get_terms($tax);
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_term_link($tax_term).'" style="color:#000000;">'.$tax_term->name.'</li></a>';
						}

				?>
            </ul>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-10">
			<?php while(have_posts()):the_post()?>
	     	<h3><?php  the_title(); ?><h3>
	     	<p><?php the_content();?></p>
	        <?php endwhile;?>
		</div>
</div>
</div><div class="clearfix"></div>

<?php get_footer();?>
?>