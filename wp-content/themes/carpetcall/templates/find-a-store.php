<?php
/* 
** Template Name: Store Main page
*/
?>
<?php get_header();?>




<div class="cbg_blk cc-clearance-blk clearfix">
      <div class="container">
        <div class="inerblock_serc cc-wrapper-whole">
              <div class="col-md-12">         
                  <div class="cc-bread-crumb">
                      <span class="cc-bread-store">CARPET CALL STORES</span>
                  </div>
                  <div class="cc-finder-title">
                      <h3>STORE FINDER</h3>
                  </div>
                  <div class="cc-options-wrapper">
                      <form method="post" >
                          <input type="hidden" name="check-near-id" value="check near value"/>
                          <input type="submit" id="cc-but-near" class="cc-but-near-con" value="FIND YOUR NEAREST STORE" name="cc-but-near-name"/>
                      </form >
                      <form method="post">
                          <input type="hidden" name="check-head-id" value="check head value"/>
                          <input type="submit" id="cc-but-head" class="cc-but-head-con" value="HEAD OFFICES" name="cc-but-head-name"/>
                      </form>
                  </div> 
                  <?php  
                
                    echo  do_shortcode('[wpsl template="custom" ]');
            
                    ?>

                  <?php if(!isset($_POST["cc-current-location-store"]) && !isset($_POST["wpsl-search-input"])){
                                  if(isset($_POST["check-near-id"])){?>
                     

                      <div id="gmap" style="height: 500px; width:100%;"></div>

                      <div class="cc-store-list-section">

                          <h4>SHOWING STORES AUSTRALIA WIDE </h4>

                          <?php 
                            $tax = 'wpsl_store_category';
                            $tax_terms = get_terms($tax, array('hide_empty' => true));
                           
                            $regions = array(
                              'QLD' => 'Queensland',
                              'NSW' =>'New South Wales',
                              'SA' =>'South Australia',
                              'TAS'=>'Tasmania',
                              'VIC'=>'Victoria',
                              'WA'=>'Western Australia',
                              'ACT'=>'Australia Capital Territory',
                              'NT'=>'Northern Territory'
                              );
                            foreach($tax_terms as $term):
                             
                              echo '<div class="cc-state-link"><a href="'.site_url().'/find-a-store/'.strtolower($term->name).'" >'.$regions[$term->name].'</a></div>';
                              endforeach; ?>
                        </div>

                    <?php    }
                        elseif(isset($_POST["check-head-id"])){?>
                       <div id="Map" style="width: 100%; height: 450px;"></div>
                          
                      <?php  echo "hellos"; } 
                    
                      else {?>
                       
                     <div id="gmap" style="height: 500px; width:100%;"></div>
                     <div class="cc-store-list-section">

                          <h4>SHOWING STORES AUSTRALIA WIDE </h4>

                          <?php 
                            $tax = 'wpsl_store_category';
                            $tax_terms = get_terms($tax, array('hide_empty' => true));
                           
                            $regions = array(
                              'QLD' => 'Queensland',
                              'NSW' =>'New South Wales',
                              'SA' =>'South Australia',
                              'TAS'=>'Tasmania',
                              'VIC'=>'Victoria',
                              'WA'=>'Western Australia',
                              'ACT'=>'Australia Capital Territory',
                              'NT'=>'Northern Territory'
                              );
                            foreach($tax_terms as $term):
                             
                              echo '<div class="cc-state-link"><a href="'.site_url().'/find-a-store/'.strtolower($term->name).'" >'.$regions[$term->name].'</a></div>';
                              endforeach; ?>
                        </div>
                      <?php }
                    }
                      ?>

                      
                  </div>
              </div>
          </div>
  </div>
<style>
.cc-wrapper-blk{
background:#f0f2f1 !important;
}
.cc-wrapper-whole h3{
  text-decoration:none !important;
  border:none;

}
.cc-contact-side{
  
}
.cc-form-wrapper{
  padding:5px;}
#wpsl-stores{
  overflow:visible !important;
}
.fcnt-orr-map a {
  background:#fff;
  border:1px solid #1858b8;
  color:#1858b8;
} 
.fcnt-orr-map a:hover{
background:#fff;
}
.cc-main-map-store{
    width:100%;
    height:465px;
}
.cc-store-list-section{
  margin:10px 0px;
}
.cc-store-list-section h4{
  padding:10px 0px;
  color:#15489f;

}
.cc-finder-title{
  margin:5px 0px;
}
.cc-finder-title h3{
   padding:10px 0px;
}
.cc-bread-crumb{
margin:5px 0px;
}
.cc-bread-crumb h3{
    padding:10px 0px;
}
.cc-tab-store{
  background:#ffffff;
  padding:5px;
}
.nav-tabs>li>a:hover>li.active>a, .nav-tabs>li>a:hover>li.active>a:focus, ..nav-tabs>li>a:hover>li.active>a:hover{
    border:none !important;
}
c-state-link{
  margin:5px 0px;
}
.cc-state-link a{
 padding:10px 0px;
 text-decoration:none;
}
</style>
<?php get_footer(); ?>



                         <?php 
                            if(!isset($_POST["cc-current-location-store"]) && !isset($_POST["wpsl-search-input"])){
                                  if(isset($_POST["check-near-id"])){
                                           get_template_part('content','main-store-map');
                                  }
                                  elseif(isset($_POST["check-head-id"])){
                                    
                                    
                                      get_template_part('content','auxuliary');
                                  }
                                 
                                  else{
                                    get_template_part('content','main-store-map');
                                  }
   
                             }
     
?>
