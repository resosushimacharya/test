<?php 
/*
*Template Name:Clearance
*/
?>
<?php 
get_header();
?>

 <div class="cbg_blk cc-wrapper-blk clearfix">
 <div class="container">
<div class="inerblock_clearn cc-clearance-whole">
					
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
	<div class="inerblock_clernn">
		
		
			<div class="cbg_content cc-clearance-wrapper clearfix">
            <?php 

             	$rows = get_field('clearance__posts',$post->ID);
                if( $rows ) {
             	foreach($rows as $row):?>
             	<div class="col-md-12 cc-clearance-row">
             	<?php
                      if(strcasecmp($row['ad_type'],'video')!=0){?>
                   	<div class="col-md-4 cc-clearance-left">
                      <img src="<?php echo $row['featured_image']['url'];?>"/ class="img-responsive">
                      <?php if($row['sticker']){?>
<span class="cc-clearance-overlay"><?php echo $row['sticker'];?></span><?php 
}?>
                      </div>
                  <?php }
                   else{ ?>
                   <?php $videolink = 'https://www.youtube.com/embed/'.$row['featured_video'];?>
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
                    	<h4 ><?php echo $row['title'];?></h4>
                    	<p><?php echo $row['description'];?></p>
                    	<?php 
                    	$win = $row['window']; 
                    	if(strcasecmp($row['ad_type'],'doc')!=0){?>
                    	<?php $link=null;
                        if($row['link_url'] && $row['link_title']){
                        $link = $row['link_url'];	
                        $title = $row['link_title'];  
                        ?>
                        <div class="nowspe nowsppe pull-right">
                        <a href="<?php echo $link;?>" <?php echo (strcasecmp($win, 'yes')== 0)?'target="_blank"':null;?>>
                            <?php echo $title;?>
                        </a>
                        </div>
                        <?php } ?>
                    	
                    <?php } else 
                    {
                            $win = $row['window']; 
                            $doc_url = $row['featured_document']['url'];
                            $title = $row['link_title'];

                            if( $doc_url && $title ) {
                    	?>
	                    <div class="nowspe nowsppe pull-right">
	                    <a href="<?php echo $doc_url; ?>" target="_blank">
	                     <?php echo $title;?> 
	                     </a>
	                     </div>

                    <?php 
                            }#end-if
                        }#end-else
                    ?>

                    </div>
                   
</div>

            <?php  endforeach;
        }# end-if
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
    z-index:2;
    color:#ffffff;
}

.cc-clearance-whole h3{
	text-decoration:none !important;
	border:none;

}
.cc-wrapper-blk{
	background:#f0f2f1 !important;
}
</style>
<?php 
get_footer();
?>