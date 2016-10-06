




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
		if(strcasecmp($root,'carpets')==0){
		$root =	'carpet';
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
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#collapseDetail"> Details
                        </a>
                    </h4>
                </div>
                                    <div id="collapseDetail" class="panel-collapse collapse ">
                                        <div class="panel-body">    <?php 
                    $details = get_field('product_tab_description',$post->ID);
                    if(!empty($details)){
                        echo $details;
                    } ?></div>
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

        </div>

