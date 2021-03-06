 <?php 
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  $bgID = 1690;
  $proID = 1711; 
  $faqID = 1725;
  $rugID = 1700;
  $hardID = 1234;
  $rootID=1639;

}
else{
  $bgID = 26696;
  $proID = 26709; 
  $faqID = 26721;
  $rugID = 26701;
  $hardID = 26703;
  $rootID=26690;
}

 ?>

<div class="cc-breadcrumb">
<span class="cc-bread-root"><a href="<?php echo get_the_permalink($rootID);?>"><?php echo get_the_title($rootID);?> </a></span><?php 
echo ' > ' ; ?><span class="cc-bread-parent"><a href="<?php echo get_the_permalink($post->post_parent);?>"><?php echo get_the_title($post->post_parent);?></a></span><?php 
echo ' > ' ; ?><span class="cc-bread-current"><?php echo get_the_title().' '.get_the_title($post->post_parent);?></span>
</div>
<h1><span class="ab_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></span> <?php echo get_the_title();?> <?php echo get_the_title($post->post_parent);?> </h1>
  
           
</div>
</div>
</div>
<!-- content section -->
<div class="faq-cont-blka">
 <div class="container clearfix">
	<div class="inerblock_sec">
		<div class="col-md-3 no-pl">
        <div id="stickSide">
        <div class="meromm" data-spy="affix" data-offset-top="138">
			
<?php 
 $res = get_field('buying_guide_archive', get_the_id());

  if($post->post_parent!=$faqID){ ?>
<?php 

        
        $i = 0;
        if($res){
          echo '<ul class="guide_list_cbg nav">';
        foreach ($res as $rs) {
            $i++;
?>
                     <?php
            echo '<li><a href="' . '#guide_item_' . $i . '">' . $rs['title'] . '<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
?>
                     
                  <?php
        }
          echo '</ul>';
      }
 }
 else{

$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $faqID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );

$page_id = get_the_ID();
$parent = new WP_Query( $args );

  if( $parent->have_posts() ) {
    echo '<ul class="guide_list_cbg">';
    while($parent->have_posts()){
        $parent->the_post();
        
        $menu_class = '';
        if( $page_id == $post->ID ) $menu_class .= ' class="current_page_item"';
    
         echo '<li' . $menu_class . '><a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). ' FAQ <i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
    }# end-while
    echo '</ul>';
  }# end-if
wp_reset_query();

 }
 ?>
</ul>

<?php 
#if($post->ID==$rugID || $post->ID==$hardID){
$button_title = get_field( 'button_title' );
$button_link = get_field( 'button_link' );
if( '' != $button_title && '' != $button_link ) {
?>
<div class="nowspe nowsppe">
  <a href="<?php echo $button_link; ?>" title="<?php echo $button_title; ?>"><?php echo $button_title; ?></a>
</div>
<?php } ?>
            </div>
            </div>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-9">
			<div class="cbg_content">
     <?php if($post->post_parent!=$faqID){ ?>
        <?php 
if(have_posts()):

    while(have_posts()):
      the_post();

     

       the_content();

    endwhile;


  else:
    echo "not found";


  endif;

?>

 <?php
			  $i = 0;
        if($res){
         foreach($res as $rs){
                  	$i++;?>

                      <h3 id="<?php echo "guide_item_".$i; ?>"><?php echo $rs['title'];?></h3>
                      <p> <?php echo $rs['description'];?></p>
                  <?php  } 
              }
            }
            ?>
            <?php 
if($post->post_parent==$faqID){?>
	        <div class="cont-panl">
			

					
			
					<?php  $i = 0;
           if($res){
           foreach($res as $rs){
                  	$i++;?>
                 <div class="panel-group" id="accordion_<?php echo $i;?>">     
                  
					<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>">
          <span class="pull-right glyphicon <?php echo ($i==1)?'glyphicon-chevron-up':'glyphicon glyphicon-chevron-down'?>"></span>
          <?php echo $rs['title'];?>
        </a>
      </h4>
    </div>
    <div id="collapse_<?php echo $i;?>" class="panel-collapse collapse <?php echo ($i==1)?'in':'' ;?> ">
      <div class="panel-body">
        <div class="panel-body-table">
          <?php echo $rs['description'];?>
        </div>
      </div>
    </div>
  </div>
				
</div>
            
            <?php  } 
            }
            ?>
<?php }
?>
</div>
             </div>
		</div>
</div>
</div>
</div>
    <script>
        jQuery(document).ready(function($) {
    $('ul.guide_list_cbg li a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });
  });
	
<?php 
  // accordion helpers for FAQ articles
  if($post->post_parent==$faqID) {
?>

    // toggle show-hide of FAQ accordion
    $('.collapse').on('shown.bs.collapse', function(){
          $(this).parent()
             .find(".glyphicon-chevron-down")
             .removeClass("glyphicon-chevron-down")
             .addClass("glyphicon-chevron-up");
    }).on('hidden.bs.collapse', function(){
      $(this).parent()
             .find(".glyphicon-chevron-up")
             .removeClass("glyphicon-chevron-up")
             .addClass("glyphicon-chevron-down");
  });
<?php } #end-if ?>


jQuery(document).ready(function(){
	var stickWidth = jQuery('.meromm').innerWidth();
	jQuery('.meromm').width(stickWidth);	
	jQuery('body').scrollspy({
	 target: "#stickSide",
	 offset: jQuery('.banner').outerHeight(true) + 20
  });
   });</script>
<?php get_footer(); ?>