




<?php $prourl = site_url();
      $prourl =explode('/',$prourl);
      if(strcasecmp($prourl[2], 'localhost')==0){
      	$profaqid = '1725';
      }
      else{
      	$profaqid = '26721';

      }
      ?>
      

     
			
<?php
global $post;
$listcat=get_the_terms($post->ID,'product_cat');

foreach($listcat as $cat){
	if($cat->parent==0){
		//echo "that's the correct answer";
		$root = $cat->slug;
		$rootname = $cat->name;
		if(strcasecmp($root,'hard-flooring')==0){
		$root =	'hard-floor';
		}
	}
	else{
		//echo "that's the bullshit answer";
	}
}
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $profaqid,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'name' => $root

 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    $faqid =$post->ID;

}


wp_reset_query();

$list = get_field('buying_guide_archive',$faqid );

?>



			 <div class="panel-group single-produc-acc-cntr" id="single-product-acc">
		
		 <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#deatials_mobile"> Details
                        </a>
                    </h4>
                </div>
                <div id="deatials_mobile" class="panel-collapse collapse ">
                    <div class="panel-body"> 
                    <?php  	 echo '<h2 class="detail-heading-item">Overview</h2>';
							$d1 = get_field('description_1',$post->ID);
							$d2 = get_field('description_2',$post->ID);
							$d3 = get_field('description_3',$post->ID);
							$d4 = get_field('description_4',$post->ID);
							$yarn=get_field('yarn_type',$post->ID);
							$length= get_post_meta( $post->ID, '_length', TRUE );
							$width= get_post_meta( $post->ID, '_width', TRUE );
							$height= get_post_meta( $post->ID, '_height', TRUE );
							$weight= get_post_meta( $post->ID, '_weight', TRUE );
							if(!empty($d1)){
							echo '<p>'.$d1.'</p>';
							}
							if(!empty($d2)){
							echo '<p>'.$d2.'</p>';
							}
							if(!empty($d3)){
							echo '<p>'.$d3.'</p>';
							}
							if(!empty($d4)){
							echo '<p>'.$d4.'</p>';
							}
							echo '<h3 class="detail-heading-item-spec">SPECIFICATIONS</h3>';?>
							<ul class="specific-list">
							<?php if(!empty($yarn)){?>
							<li><span>Yarn Type : </span><?php echo $yarn; ?></li><?php }?>
							<?php if(!empty($length) && !empty($width) && !empty($height)) {?>
							<li><span>Size : </span><?php echo $length.'cm x '.$width." ".$height;?> 
							</li>
							<?php }?>
							<?php if(!empty($weight)){?>
							<li><span>Weight : </span><?php echo $weight." kg"; ?> </li>
							<?php }?>
							</ul>
					</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#collapseOne"> Care Instructions
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse ">
                    <div class="panel-body">    <?php 
$careins = get_field('care_instructions',$post->ID);
if(!empty($careins)){
	echo '<p class="clcc-care_inst">'.$careins.'</p>';
} ?></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#collapseTwo">FAQ'S
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        
                           
                            <div class="panel-group" id="accordion21">
                             <?php
					
					 $faqcounter = 1;
					 ?>
					
					 <?php 
					 if($list){ 
					foreach($list as $listitem){
					

					
					
					?>
                                <div class="panel">
                                    <div class="panel-heading">
                                    <a data-toggle="collapse" data-parent="#accordion21" href="#collapse_mobile_<?php echo $faqcounter ;?>"><?php echo $listitem['title'];?>
                                    </a>
                                    </div>
                                    <div id="collapse_mobile_<?php echo $faqcounter ;?>" class="panel-collapse collapse">
                                        <div class="panel-body"><?php echo $listitem['description']; ?></div>
                                    </div>
                                </div>
                               
                            <?php 
                              $faqcounter++;
                            }
                            } ?>
                            
                            </div>
                        
                    </div>
                </div>
            </div>
                  <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#return_mobile"> Return Policy 
                        </a>
                    </h4>
                </div>
                <div id="return_mobile" class="panel-collapse collapse ">
                    <div class="panel-body"> 

                     <?php 
										global $post;
										
										$term = '';
										$reqTempTerms=get_the_terms($post->ID,'product_cat');
										if($reqTempTerms){
												foreach($reqTempTerms as $cat){
													if($cat->parent==0){
														$term = $cat;
														break;
														}
													}
											if($term !=''){
											$retinfo = get_term_meta($cat->term_id,'cat_return_policy',true);
											echo '<p class="returns_text">'.$retinfo.'</p>';
											}
										}


/*
										$url = site_url();
										$url =explode('/',$url);

										if(strcasecmp($url[2],'localhost')==0){
										  $retID = 31856;
										 

										}
										else{
										  $retID = 33274;
										}
										$retinfo = get_field('return_policy',$retID);
										echo '<p class="returns_text">'.$retinfo.'</p>';
										*/

										?>

					</div>
                </div>
            </div>

        </div>