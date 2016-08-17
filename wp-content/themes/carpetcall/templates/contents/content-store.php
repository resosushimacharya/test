<?php
/* store finder */
?>
<div class="dropdown storefinder_cntr" id="storefinder_id">
  
  <button class="dropbtn storefinder_btn-class" id="storefinder_btn">
      <img src="<?php echo get_template_directory_uri();?>/images/indicator.png" width="20" height="28" style=" float:left; margin:5px 11px 0 0;"/>
       STORE FINDER  <i class="fa fa-angle-down" aria-hidden="true"></i> 
  </button>
  <div class="dropdown-content" id="after_dropdown">
    
      <div>
              <div id="directory_list_id_s"></div> <!-- useful ajax call do not delete it. -->
      </div>
    
    <!--first sec end  -->
    
      <div class="loplc">
            <h3 id="before_heading">FIND YOUR NEAREST STORE<span>:</span> </h3>
            <h3 id="after_heading" style="display:none;">FIND MORE STORES: </h3>
            <div class="srch_pro">
                  <div class="row">
                        <div class="col-lg-12">
                    
                               <div class="input-group">
                                    <input id="edit_dir_keyword" name="edit_dir_keyword" type="text" class="form-control controls" placeholder="suburb or postcode" onkeyup="mymap(event);">
                                    <span class="input-group-btn">
                                          <button class="btn btn-default" type="button" onclick="rs='';autocomplet();" id="check_control">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="626" height="626" viewBox="0 0 626 626" fill="#808080"><path d="M234.502 468.998C105.024 469.033-.248 364.54.162 234.145.572 103.867 104.737.123 234.957.16 365.233.194 469.347 105.7 469.03 235.294c-.316 129.3-105.033 233.77-234.528 233.703zM58.722 235.14c.39 97.628 79.406 175.614 175.932 175.53 97.425-.083 176.05-79.147 176.148-175.985.098-96.948-79.577-176.324-176.626-175.965-97.164.36-175.857 79.485-175.455 176.42zm323.766 229.716c33.232-21.7 60.585-48.976 83.233-83.725 2.076 2.764 3.414 5.066 5.23 6.89 45.408 45.505 90.928 90.897 136.274 136.462 14.354 14.424 21.37 31.882 17.53 52.252-4.316 22.89-17.586 38.725-40.127 45.99-22.942 7.392-42.994 1.375-59.6-15.042-47.256-46.715-94.08-93.866-141.07-140.852-.344-.345-.593-.788-1.468-1.972z"/></svg>
                                          </button>
                                    </span>
                        
                                </div>
                                <div class="input-group" id="directory_list_id"></div> <!-- useful ajax call  do not delete it.-->
                  
                        </div>
                  </div><!-- /.row -->
            </div>
            <div class="clearfix"></div>
            
            <div class="curlocate input" id="after_location">
                  <input type="button" class="userlocation" onclick="showlocation();rs='';" value="USE CURRENT LOCATION"/>
            </div>
            <div class="clearfix"></div>
              <?php
                  $url = site_url();
                  $url =explode('/',$url);
                    if(strcasecmp($url[2],'localhost')==0){
                        $locsermapID = '1770';
                    }
                  else{
                         $locsermapID ='26771'; 
                       }
            
              
                  $store_page_url = get_the_permalink($locsermapID);
              ?>
              
              <div class="curnloc curnloca" id="after_browse">
                  <a href="<?php echo $store_page_url; ?>">BROWSE ALL STORES</a>
              </div>
              <div class="clearfix"></div>
        </div>
          <!--more store sec end  -->
          
  </div>
</div><!-- store finder menu end -->
        <script>
                var input = document.getElementById('edit_dir_keyword');
                var stoLocation= [];
                var diaLocation = [];
                function mymap(e) {
                          var input = document.getElementById('edit_dir_keyword');
                          var options = { types: ['geocode'],componentRestrictions: {country: "AU"} };
                          var types = document.getElementById('type');
                          var check = input.value;
                          
                          
                          e.which = e.which || e.keyCode;
                          if(e.which == 13) {
                                      document.addEventListener("keydown", KeyCheck);
                                      google.maps.event.clearListeners(input, "focus");
                                      google.maps.event.clearListeners(input, "blur");
                                      google.maps.event.clearListeners(input, "keydown");
                                      $(".pac-container").hide();
                                      autocomplet();
                          }
                        
                          $("#check_control").addClass("store-key-control");
                          var autocomplete = new google.maps.places.Autocomplete(input,options);
                       
                          
                          
                          autocomplete.addListener('place_changed', function(){
                          
                                      var place = autocomplete.getPlace();
                                      stoLocation.push(place);
                                      stoLocation = [place.geometry.location.lat(),place.geometry.location.lng()];
                                     
                                      
                                      if (!place.geometry) {
                                                window.alert("Autocomplete's returned place contains no geometry");
                                                return;
                                      }
                                  
                          
                          
                          })
                              
                              
                      document.addEventListener("keydown", KeyCheck);
                
                
                }
                function KeyCheck(event){
                          var KeyID = event.keyCode;
                          switch(KeyID)
                          {
                              case 8:
                                    setTimeout(function(){
                                        document.addEventListener("keydown", KeyCheck);
                                        google.maps.event.clearListeners(input, "focus");
                                        google.maps.event.clearListeners(input, "blur");
                                        google.maps.event.clearListeners(input, "keydown");
                                    },500);
                                  
                               break;
                              
                              
                              default:
                                  break;
                          }
                }
                function customDialog(e) {
                          var input = document.getElementById('edit_dialog_keyword');
                          var options = { types: ['geocode'],componentRestrictions: {country: "AU"} };
                          var types = document.getElementById('type');
                          var check = input.value;
                          
                          
                          e.which = e.which || e.keyCode;
                          if(e.which == 13) {
                                      document.addEventListener("keydown", KeyCheck);
                                      google.maps.event.clearListeners(input, "focus");
                                      google.maps.event.clearListeners(input, "blur");
                                      google.maps.event.clearListeners(input, "keydown");
                                      $(".pac-container").hide();
                                      autocomplet_dialog();
                          }
                          
                          $("#check_control_dialog").addClass("store-key-control");
                          var autocomplete = new google.maps.places.Autocomplete(input,options);
                      
                          
                          
                          autocomplete.addListener('place_changed', function() {
                                      
                                      var place = autocomplete.getPlace();
                                      diaLocation.push(place);
                                      diaLocation = [place.geometry.location.lat(),place.geometry.location.lng()];
                                   
                                      
                                      if (!place.geometry) {
                                      window.alert("Autocomplete's returned place contains no geometry");
                                      return;
                                      }
                                      
                          
                          
                          });
                          document.addEventListener("keydown", KeyCheck);
           
                
                }
     </script>
               