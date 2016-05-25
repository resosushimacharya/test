<?php 
/* store finder */
?>




                        <div class="dropdown storefinder_cntr">
                        
                          <button class="dropbtn" id="storefinder_btn"><img src="<?php echo get_template_directory_uri();?>/images/indicator.png" width="20" height="28" style=" float:left; margin:5px 10px 0 0;"/>STORE FINDER &nbsp; <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
                          <div class="dropdown-content">
                    
                            <div>
                            <div id="directory_list_id_s"></div>
                            
                            
                            </div>
                            
                            <!--first sec end  -->
                           
                            <div class="loplc">
                            <h3>FIND MORE STORES </h3>
                            
                            <div class="srch_pro">
                            <div class="row">
                                  <div class="col-lg-12">
                                    <form role="search" method="get" id="" class="" action="">
    <div class="input-group">
      <input id="dir_keyword" name="dir_keyword" type="text" class="form-control" placeholder="Search for..." onkeyup="storecomplet()" autocomplete="off">
      
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" onclick="autocomplet();"><i class="fa fa-search" aria-hidden="true"></i></button>
      </span>

          
                   
        
    </div><div class="input-group">
     <ul id="directory_list_id"></ul></div>
</form><!-- /input-group -->
                                  </div><!-- /.col-lg-6 -->
                                </div><!-- /.row -->
                            </div><div class="clearfix"></div>
                            
                            <div class="curlocate input">
                            <input type="button" class="userlocation" onclick="showlocation();" value="USE CURRENT LOCATION"/>
                            </div><div class="clearfix"></div>
                            
                            
                            <div class="curnloc curnloca">
                            <a href="#">BROWSE ALL STORES</a>
                            </div><div class="clearfix"></div>
                            
                            
                            
                            </div>
                            <!--more store sec end  -->
                            
                          </div>
                        </div><!-- store finder menu end -->