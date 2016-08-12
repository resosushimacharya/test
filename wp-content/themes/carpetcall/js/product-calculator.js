/* this is script for calculator section of product in store */
$(".form-square-meter").submit(function(e){
    e.preventDefault();
  });
$ = jQuery.noConflict();
    $(document).ready(function() {
        $("#cal_more").click(function() {
        		var count = $("#calculator_container>div").length;
        		count = count + 1;
              $("#calculator_container").append('<div class="row" id="row_cal_'+count+'"> <div class="col-md-8 col-item-price"><div class="cal_pro" id="cal_pro_'+count+'"> <div class="container_'+count+'"><div class="form-group col-md-6"> <div class="col-md-6"> <label for="width_'+count+'">Room '+count+' Width(m)</label> </div> <div class="col-md-6"> <input type="text" class="form-control" id="width_'+count+'" placeholder="" name="width_'+count+'"> </div> </div> <div class="form-group col-md-6"> <div class="col-md-6"> <label for="legth_'+count+'">Length(m)</label> </div> <div class="col-md-6"> <input type="text" class="form-control" id="length_'+count+'" placeholder="" name="length_'+count
              	+'"> </div> </div> </div> </div> </div> <div class="col-md-4 "> <div class="form-group col-md-8"> <input type="text" class="form-control col-md-8 item_indivisual_total" id="item_total_'+count
              	+'" placeholder="" name="item_total_'+count
              	+'" readonly> </div> <div class="form-group col-md-4"> m<sup>2</sup> </div> </div> </div> ');

        });

    });

	 $(document).ready(function() {

       $(document).on('click','#cal_id',function(){
       	/*alert($("#calculator_container>div").length);*/
       	$loop =$("#calculator_container>div").length;
         $calarea = 0;
       	/*alert($loop);*/
       	$covperpack =$('#cov_per_pack').val();
       	if($('#cov_per_pack').val()===""){
       		alert("plese enter coverage per pack!");

       	}
       	  else{
       	for($i=1;$i<=$loop;$i++){
       		$length = '#length_'+$i;
       		$width = '#width_'+$i;
       		$item_id= '#item_total_'+$i;
       		$temp = $($length).val()*$($width).val();
            $($item_id).val($temp);  

    $calarea +=$temp;
	}
	
	
  $noofpacks = Math.ceil($calarea/$covperpack);
	
  $estarea= $noofpacks*$covperpack;
  $excarea=$estarea.toFixed(2) - $calarea;
  $excareaPer=$excarea/$calarea*100;
  
  $excareaPer=Math.ceil($excareaPer);
  $("#exceess_area_percent").val($excareaPer);
  $('#total_area').val($calarea);
  $("#no_of_packs").val($noofpacks);
    /*for DU1133 TPM and  1.6 area/quantiy */ 
   $apq = 1.6;
    $quantity = Math.ceil($estarea/$apq); 
}
   /* alert($quantity);
*/

       	});

/* to erase the data and added div */


       $(document).on("click",'#cancel_calc',function(){
                    

             
       $("#exceess_area_percent").val('');
        $('#total_area').val('');
        $("#no_of_packs").val('');
        $loop =$("#calculator_container>div").length;
         $calarea = 0;
       	/*alert($loop);*/
       	$covperpack = 2.49;
       	  
       	for($i=1;$i<=$loop;$i++){
       		$length = '#length_'+$i;
       		$width = '#width_'+$i;
       		$item_id= '#item_total_'+$i;
       		$($length).val('');
       		$($width).val('');
       		 $($item_id).val('');
       		 if($i>=2){
               $rowid = '#row_cal_'+$i;
       		 	 $($rowid).remove();
       		 }
       	
           

	}


       });

	 	 });



