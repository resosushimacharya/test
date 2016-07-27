    <?php 
/* store finder */
?>




                        <div class="dropdown storefinder_cntr" id="storefinder_id">
                        
                          <button class="dropbtn" id="storefinder_btn"><img src="<?php echo get_template_directory_uri();?>/images/indicator.png" width="20" height="28" style=" float:left; margin:5px 11px 0 0;"/>STORE FINDER  <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
                          <div class="dropdown-content" id="after_dropdown">
                    
                            <div>
                            <div id="directory_list_id_s"></div>
                            
                            
                            </div>
                            
                            <!--first sec end  -->
                           
                            <div class="loplc">
                            <h3 id="before_heading">FIND YOUR NEAREST STORE: </h3>
                            <h3 id="after_heading" style="display:none;">FIND MORE STORES: </h3>
                            <div class="srch_pro">
                            <div class="row">
                                  <div class="col-lg-12">
                                   
    <div class="input-group">
      <!-- <input id="dir_keyword" name="dir_keyword" type="text" class="form-control" placeholder="suburb or postcode"  autocomplete="off" onkeyup="storecomplet()" 
      onkeypress="handle(event)"> -->
      <input id="edit_dir_keyword" name="edit_dir_keyword" type="text" class="form-control controls" placeholder="suburb or postcode" onkeyup="mymap(event);">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" onclick="rs='';autocomplet();" id="check_control_dialog">
        <img src="<?php  echo get_template_directory_uri();?>/images/magnify.png"/>
        </button>
      </span>

          
                  
        
    </div><div class="input-group" id="directory_list_id">
     </div>
    <!--<div class="input-group">
     <ul id="directory_list_id"></ul></div>-->
<!-- /input-group -->
                                  </div><!-- /.col-lg-6 -->
                                </div><!-- /.row -->
                            </div><div class="clearfix"></div>
                            
                            <div class="curlocate input" id="after_location">
                            <input type="button" class="userlocation" onclick="showlocation();rs='';" value="USE CURRENT LOCATION"/>
                            </div><div class="clearfix"></div>
                             <?php 
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  $locsermapID = '1770';
}
else{
  $locsermapID ='26771'; }


 ?>
                            <?php
                             
                              $store_page_url = get_the_permalink($locsermapID);
                            ?>
                            
                            <div class="curnloc curnloca" id="after_browse">
                            <a href="<?php echo $store_page_url; ?>">BROWSE ALL STORES</a>
                            </div><div class="clearfix"></div>
                            
                            
                            
                            </div>
                            <!--more store sec end  -->
                            
                          </div>
                        </div><!-- store finder menu end -->
 <script>

  var stoLocation= [];
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
        if(check.length>3){
        $("#check_control").addClass("store-key-control");
        var autocomplete = new google.maps.places.Autocomplete(input,options);
      //  console.log(autocomplete);
      

        
        autocomplete.addListener('place_changed', function() {
         
          var place = autocomplete.getPlace();
           stoLocation.push(place);
          stoLocation = [place.geometry.location.lat(),place.geometry.location.lng()];
          //input.value="";

         
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          
          

         
        });
      document.addEventListener("keydown", KeyCheck); }
        else{
          document.addEventListener("keydown", KeyCheck); 
          google.maps.event.clearListeners(input, "focus");
        google.maps.event.clearListeners(input, "blur");
        google.maps.event.clearListeners(input, "keydown");

    $(".pac-container").hide();
        }


       
      }
       //or however you are calling your method
function KeyCheck(event)
{
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
       autocomplet();
    }
        if(check.length>3){
        $("#check_control_dialog").addClass("store-key-control");
        var autocomplete = new google.maps.places.Autocomplete(input,options);
      //  console.log(autocomplete);
      

        
        autocomplete.addListener('place_changed', function() {
         
          var place = autocomplete.getPlace();
           stoLocation.push(place);
          stoLocation = [place.geometry.location.lat(),place.geometry.location.lng()];
          //input.value="";

         
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          
          

         
        });
      document.addEventListener("keydown", KeyCheck); }
        else{
          document.addEventListener("keydown", KeyCheck); 
          google.maps.event.clearListeners(input, "focus");
        google.maps.event.clearListeners(input, "blur");
        google.maps.event.clearListeners(input, "keydown");

    $(".pac-container").hide();
        }


       
      }
    </script>
    <script>
      function storekeycheck(e) {
    e.which = e.which || e.keyCode;
    if(e.which == 13) {
        // submit
    }
}
    </script>
  