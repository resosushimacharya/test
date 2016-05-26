 <div class="meroshop"><div class="container">
        	<div class="row">
            <div class="col-md-12">
            
             <?php 
             $headings= get_field('heading_bar','option');
           foreach($headings as $heading):?>
           <div class="col-md-4 no-lr">
                <div class="shopping">
                
                    <div class="aag">
                    <img src="<?php echo $heading['icon']['sizes']['thumbnail'];?>"  alt="icon" style="float:left;"/>
                    <h3 class="so_title so_titlee">
                   
                     <?php echo $heading['title'];?> </h3>
                    <p><?php echo $heading['description'];?> </p>
                    
                    </div><div class="clearfix"></div>
                    
                </div>
                </div>
            <?php 
            endforeach;

             ?>
            	<!-- product delivery end here  -->
                
            </div>
            </div>
            
            <div class="clearfix visible-md"></div>
            
        </div></div><div class="clearfix"></div>



        