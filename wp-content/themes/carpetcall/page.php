<?php

 get_header();
?>

<div class="child-innerpg">
   <div class="container clearfix">
       <div class="inerblock_serc_child">
         <?php 
         if(have_posts()):
            while(have_posts()):
            	the_post();
                echo '<h3>'.get_the_title().'</h3>';
                the_content();
                
            endwhile;
                


         else:
          echo "Sorry no post found.";
         endif;



         ?>
       </div>
  </div>
</div>
<div class="clearfix"></div>

 <?php get_footer();


 ?>