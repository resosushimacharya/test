<?php
/*section for home product display*/
$post_type = 'product';
$tax = 'product_cat';
$tax_terms = get_terms($tax);
//do_action('pr',$tax_terms);
$count=count($tax_terms);
//print_r($tax_terms);
?>
<div class="flotb">
	<div id="horizontalTab">
<?php
					if ($tax_terms) {
						$i=1;
					$variable = 1 ;$check=1;
					foreach($tax_terms as $tax_term){
						if($variable==1)
					echo '<ul><li><a href="#tab-'.$variable.'">'.$tax_term->name.'</a></li>';
					elseif($count==$variable)
						echo '<li><a href="#tab-'.$variable.'">'.$tax_term->name.'</a></li></ul>';
					else
						echo '<li><a href="#tab-'.$variable.'">'.$tax_term->name.'</a></li>';
					$variable++;
					}
					foreach ($tax_terms  as $tax_term) {
					/*echo $tax_term->slug;*/
					$args=array(
					'post_type' => $post_type,
					"$tax" => $tax_term->slug,
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'ignore_sticky_posts'=> 1
					);
					//echo $tax_term->slug;
					$my_query = null;
					$my_query = new WP_Query($args);
					if( $my_query->have_posts() ) { ?>
						<div id="tab-<?php echo $i; ?>">
			
					<section class="">
					<?php 
				$taxslug=$tax_term->slug;
				while ($my_query->have_posts()) : $my_query->the_post();
				$woo=get_post_meta($post->ID);
				// do_action('custom_hook_inspect_carpetcall',get_post_meta(get_the_ID()));
				$tax_term_pro='carpet';
				$res=strcmp($tax_term->slug,$taxslug);
				//echo $taxslug;
				if($res==0){?>
				<div class="">
					<div class="limblk">
						<h3> <?php the_title(); ?> </h3><?php  $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
						$ben=get_field('benefits',$post->ID);
						$con=get_field('construction',$post->ID);
						$rem=get_field('recommended_for',$post->ID);
						
						$price=$woo['_regular_price'][0];
						//echo $con;?>
						<img src="<?php echo $feat_image; ?>" alt="carpet" class="img-responsive"/>
						<div class="limblkk">
							<h4> CONSTRUCTION </h4>
							<p><?php echo $con; ?></p>
						</div>
						<div class="clearfix"></div>
							<div class="sublim">
								<h4> BENEFITS </h4>
								<p><?php echo $ben ;?></p>
							</div>
							<div class="clearfix"></div>
								<?php if(!empty($price)){ ?>
								<div class="sublim">
									<h4> PRICE </h4>
									<p>$<?php echo $price;?></p>
								</div>
								<?php } ?>
								<div class="clearfix"></div>
								<div class="sublim">
									<h4> RECOMMENDED FOR </h4>
									<p><?php echo $rem ;?> </p>
								</div>
									<div class="clearfix"></div>
									
									<div class="shnow shnoww">
										<a href="<?php the_permalink(); ?>"> SHOP NOW </a>
									</div>
									<div class="clearfix"></div>
										<?php
										
										
										$ben=get_field('benefits',$post->ID);
										$con=get_field('construction',$post->ID);
										$rem=get_field('recommended_for',$post->ID);
										?>
										<?php
										/*	echo '<p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
										<?php  the_post_thumbnail();
									echo $post->ID;?></p>
									<?php
									$woo=get_post_meta($post->ID);
									//do_action('pr',$woo);
									?>';*/
								?>
								</div>
							</div>
							<?php
							}
							
							endwhile;
							$i++;
						
						
						
					
					}

					echo '</section></div>';
					wp_reset_query();
					}
					}
					?>
					


					



					
					<!-- vynil end -->
					<script type="text/javascript">
					$(document).on('ready', function() {
						$(".slider").slick({
                                    dots: true,
                                    infinite: true,
                                    slidesToShow: 3,
                                    slidesToScroll: 3
                                    });
						
					});
					</script>
					
					<div class="container">
					<div class="row">
					<div class="col-md-12">
					<section class=""><div class=""><?php
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'product',
					"$tax" => 'featured',
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
					$ben=get_field('benefits',$post->ID);
					$con=get_field('construction',$post->ID);
					$rem=get_field('recommended_for',$post->ID);
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>

                    <div class="col-md-4">
                    <img src="<?php echo $feat_image; ?>" alt="carpet" class="img-responsive"/>
					<?php
					the_title();

					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					
					foreach($reqTempTerms as $reqTerm){ 
						  if($reqTerm->term_id!=20)
						  {
						  	echo $reqTerm->name;
						  }

					}
					if(!empty($price)){
						echo '<h3>'.$price.'</h3>';
					}?>
					<a href="<?php the_permalink(); ?>"> SHOP NOW </a>
					</div>
					
               <?php

					endwhile;
					wp_reset_query();
					?>
					</div></section></div></div></div>


				