 <div class="meroshop"><div class="container">
        	
            <div class="col-md-12">
            <?php

             $headings= get_field('heading_bar',274);
           foreach($headings as $heading):?>
           <div class="col-md-4">
                <div class="shopping">
                
                    <div class="aag">
                    <img src="<?php echo $heading['icon']['sizes']['thumbnail'];?>" width="41" height="43" alt="icon" style="float:left;"/>
                    <h3 class="so_title so_titlee">
                    <?php if(!empty($heading['highlight'])){?>
                    <span class="merof"><?php echo $heading['highlight'];?></span> 
                    <?php }?>
                    <a href="<?php echo $heading['link'];?>"> <?php echo $heading['title'];?> </a></h3>
                    <p><?php echo $heading['description'];?> </p>
                    
                    </div><div class="clearfix"></div>
                    
                </div>
                </div>
            <?php 
            endforeach;

             ?>
            	<!-- product delivery end here  -->
                
            </div><div class="clearfix visible-md"></div>
            
        </div></div><div class="clearfix"></div>