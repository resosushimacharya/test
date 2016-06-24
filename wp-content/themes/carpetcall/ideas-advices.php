<?php
/* Template Name: ideas and advice*/
get_header();
global $post;

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>
<div class="body-wrapper">
<div class="container">
	<div class="ideas-advice-section row">
        <div class="col-md-6 cc-ia-content">
        <h4><?php the_title();?></h4>
        <h1><?php the_title();?> </h1>
        <p><?php echo $post->post_content;?> </p>
        </div>
        <div class="col-md-6">
         <div class="cc-ia-banner">
          <img src="<?php echo $feat_image;?>" class="img-responsive">


      
         	
         </div>
        </div>
	</div>
</div>
<div class="container">
<div class="row cc-ia-item-cover">
<?php
$iadata = get_field('ideas_and_advice_page_fields');

function order_of_ideas_and_advice_function($a, $b) {
    return $a['order_of_ideas_and_advice'] - $b['order_of_ideas_and_advice'];
}
usort($iadata, 'order_of_ideas_and_advice_function');
foreach($iadata as $iad){?>
    <?php if(strcasecmp($iad['category'],'More')==0):?>
	<div class="col-md-6 cc-ia-item cc-ia-more">
		<h3><?php echo $iad['title'];?></h3>
		<?php echo $iad['description'];?>
	</div>
    <?php 
    /**
    *reading the category
    *relating with our category such as guide,faq and product care  
    *it must include in else section(exlusion of More category)
    */
    $descats=get_terms(array('slug'=>$iad['category'],'taxonomy'=>'product_cat'));
    
    ?>
    <?php elseif(strcasecmp($iad['category'],'Product Care')==0):
      $tax = 'product_care';

   
    $res_tax=strtolower($tax);
     $tax_terms = get_terms($res_tax);?>
     <div class="col-md-6 cc-ia-item">
		<h3><?php echo $iad['title'];?></h3>
		<p><?php echo $iad['description'];?></p>

            <ul class="cat_list">
            <?php
                          
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_term_link($tax_term).'">'.$tax_term->name.'</li></a>';
						}

				?>
            </ul>
	</div>
     <?php 
    
    else:
   
    $tax = explode("'",$iad['category']);

   
    $res_tax=strtolower($tax[0]);
     $tax_terms = get_terms($res_tax);
    
    ?>
   
    <div class="col-md-6 cc-ia-item">
		<h3><?php echo $iad['title'];?></h3>
		<p><?php echo $iad['description'];?></p>
		  
            
            
            <ul class="cat_list">
            <?php
                          
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_term_link($tax_term).'">'.$tax_term->name.'</li></a>';
						}

				?>
            </ul>
            
            </div>
	
<?php 
endif;
}
 ?>

</div>
</div>
</div>
<style>
.body-wrapper{
		margin:150px 0 38px 0;
}
ul.cat_list{
	text-decoration:none;
	list-style:none;

}
.cc-ia-item ul{
	list-style:none;
}
.cc-ia-more ul,.cc-ia-more ul li{
	text-decoration:none;
}
.cc-ia-more ul li i{
	float:left;
}
</style>
<script>
  $(".cc-ia-more ul li ").append('<i class="fa fa-caret-right" aria-hidden="true"></i>');
</script>

<?php 
get_footer();
?>