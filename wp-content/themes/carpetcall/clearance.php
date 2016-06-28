<?php 
/*
*Template Name:Clearance
*/
?>
<?php 
get_header();
?>

 <div class="cbg_blk clearfix">
 <div class="container">
<div class="inerblock_serc">
					
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>

</div>
 <?php while(have_posts()){
             	the_post();
             	?>
             	<h3><?php echo get_the_title();?></h3>
             
             		<?php the_content();?>
             	
            <?php  }
            wp_reset_query();?>


</div>
</div>
</div>


 <div class="container clearfix">
	<div class="inerblock_sec">
		
		
			<div class="cbg_content cc-clearance-wrapper">
            <?php 

             	$rows = get_field('clearance__posts',$post->ID);
             	foreach($rows as $row):?>
             	<div class="col-md-12 cc-clearance-row">
             	<?php
                     
                   // check whether the video link is enabled or not
         /*          Array
(
    [title] => CARPET CALL MAYHEM
    [description] => Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus orci augue, vehicula a nisi sit amet, sollicitudin suscipit ante. Etiam sapien ligula, tempus et sem nec, tristique pellentesque onec tristique tortor eget commodo faucibus corbi facilisis convallis
    [link_title] => Shop Now
    [link_url] => 
    [featured_image] => 
    [featured_video] => VzI3rDLnyMw
    [window] => No
    [whether_to_display_video_or_image] => Yes
    [sticker] => 
)
     */              if(strcasecmp($row['whether_to_display_video_or_image'],'yes')!=0){?>
                   	<div class="col-md-4 cc-clearance-left">
                      <img src="<?php echo $row['featured_image']['url'];?>"/ class="img-responsive">
                      <?php if($row['sticker']){?>
<span class="cc-clearance-overlay"><?php echo $row['sticker'];?></span><?php 
}?>
                      </div>
                  <?php }
                   else{ ?>
                   <?php $videolink = 'http://www.youtube.com/embed/'.$row['featured_video'];?>
                     	<div class="col-md-4 cc-clearance-left"> <iframe width="100%" height="auto"
src="<?php echo $videolink;?>
">
</iframe>
<?php if($row['sticker']){?>
<span class="cc-clearance-overlay"><?php echo $row['sticker'];?></span><?php 
}?>
</div>
<?php
                   }
                   ?>
                    <div class="col-md-8 cc-clearance-right">
                    	<h4><?php echo $row['title'];?></h4>
                    	<p><?php echo $row['description'];?></p>
                    	<?php 
                    	$link=null;
                        if($row['link_url']){
                        $link = $row['link_url'];	
                        };
                    	$win = $row['window']; 
                    	?>
                    	
                    	<div class="nowspe nowsppe pull-right"><a href="<?php
                         echo ($link!=null)? $link: 'javascript:void(0)';
							?>"  <?php  echo (strcasecmp($win, 'yes')== 0)?'target="_blank"':null;?>><?php echo $row['link_title'];?> </a></div>
                    
                    </div>
                   
</div>

            <?php  endforeach;
			?>




             
		</div>
</div>
</div>

<style>
.cc-clearance-row{
	padding:10px 5px;
}
.cc-clearance-overlay{
	position: absolute;
  
    top:10%;
    padding:5px;
    cursor: pointer;
    background:#a9191c;
    z-index:99999;
    color:#ffffff;
}
</style>
<?php 
get_footer();
?>