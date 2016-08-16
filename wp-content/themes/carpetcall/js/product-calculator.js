/* this is script for calculator section of product in store */

$ = jQuery.noConflict();
    $(document).ready(function() {
        $("#cal_more").click(function() {
        		var count = $("#calculator_container>div").length;
        		count = count + 1;
             /* $("#calculator_container").append('<div class="row" id="row_cal_'+count+'"> <div class="col-md-8 col-item-price"><div class="cal_pro" id="cal_pro_'+count+'"> <div class="container_'+count+'"><div class="form-group col-md-6"> <div class="col-md-6"> <label for="width_'+count+'">Room '+count+' Width(m)</label> </div> <div class="col-md-6"> <input type="text" class="form-control" id="width_'+count+'" placeholder="" name="width_'+count+'"> </div> </div> <div class="form-group col-md-6"> <div class="col-md-6"> <label for="legth_'+count+'">Length(m)</label> </div> <div class="col-md-6"> <input type="text" class="form-control" id="length_'+count+'" placeholder="" name="length_'+count
              	+'"> </div> </div> </div> </div> </div> <div class="col-md-4 "> <div class="form-group col-md-8"> <input type="text" class="form-control col-md-8 item_indivisual_total" id="item_total_'+count
              	+'" placeholder="" name="item_total_'+count
              	+'" readonly> </div> <div class="form-group col-md-4"> m<sup>2</sup> </div> </div> </div> ');
				*/
			var $html="";	
		$html+='<div class="row" id="row_cal_'+count+'">';
           $html+='<div class="col-md-8 col-item-price">';
                $html+='<div class="cal_pro" id="cal_pro_'+count+'">';
                    $html+='<div class="container_1">';
                       $html+='<div class="form-group col-md-6">';
                            $html+='<div class="col-md-6 no-lr">';
                                $html+='<label for="width_'+count+'">Room '+count+'</label>';
                            $html+='</div>';
                            $html+='<div class="col-md-6 no-lr">';
                                $html+='<input type="text" class="form-control width_check" id="width_'+count+'" placeholder=" Width (m)" name="width_'+count+'" required>';
                            $html+='</div>';
                        $html+='</div>';
                        $html+='<div class="form-group col-md-6">';
                           $html+=' <div class="col-md-6 no-lr">';
                               $html+='<label for="legth_'+count+'"></label>';
                            $html+='</div>';
                            $html+='<div class="col-md-6 no-lr">';
                                $html+='<input type="text" class="form-control length_check" id="length_'+count+'" placeholder="Length (m)" name="length_'+count+'" required>';
                            $html+='</div>';
                        $html+='</div>';
                    $html+='</div>';
                $html+='</div>';
               
           $html+=' </div>';
            $html+='<div class="col-md-3 ">';
			 		$html+='<div class="form-group col-md-8">';
                           $html+='<span class="form-control col-md-8 item_indivisual_total"> = <span id="item_total_'+count+'">-</span> SQM</span>';
                       $html+=' </div>';
            $html+='</div>';
			$html+='<div class="col-md-1 ">';
				$html+='<div class="form-group">';
					 $html+='<span class="form-control">';
                        $html+='<a class="remove_row_calc"><i class="fa fa-times-circle" aria-hidden="true"></i></a>';
					$html+='</span>';
				$html+='</div>';
            $html+='</div>';
        $html+='</div>';
				
				$("#calculator_container").append($html);

        });

    });
	
	
	
	
	
	
	
	
	////////////////////////////////////// remove row///////////////
	$(document).on('click','.remove_row_calc',function(){
		
		$(this).parents('.row').remove();
		//calculate_square();
		
	});
	
	
	////////// check number value //////////////
	function number_check(value){
		
		 var  str= value;
		   value =value.replace(/[a-z]/gi, '');
		   var realLength = str.length;
		  var  tempLength =  value.length;
		  
		  if(realLength===tempLength){
			return true;
		  }
		  else{
			return false;
		  }
	}
	
	
	
	//////////////////////// calulater number error validate//////////////////
	$(document).on('keyup','.width_check, .length_check', function(){
		
		$(this).siblings('.cc-void-field').remove();
		
		if($(this).val()===""){
		  $(this).parent().append('<div class="cc-void-field">Please fill the field!</div>');
		}else if(!number_check($(this).val())){
			 $(this).parent().append('<div class="cc-void-field">Please fill number only!</div>');
		}
		
	});
function calculate_square(){

	
	/*alert($("#calculator_container>div").length);*/
       	var $loop =$("#calculator_container>div").length;
        var  $calarea = 0;
		 var err=false;
       	/*alert($loop);*/
       	var $covperpack =$('#cov_per_pack').val();
       	if($('#cov_per_pack').val()===""){
       		alert("plese enter coverage per pack!");

       	}
       	  else{
			  
            for($i=1;$i<=$loop;$i++){
				err=false;
               if($('#length_'+$i).val()==''){
               var $myid ='#length_'+$i;
					$($myid).parent().find('.cc-void-field').remove();
                    $($myid).parent().append('<div class="cc-void-field">Please fiil the field!</div>');
					err=true;
                  }
				  if($('#width_'+$i).val()==''){
                  $myid ='#width_'+$i;
					$($myid).parent().find('.cc-void-field').remove();
                   $($myid).parent().append('<div class="cc-void-field">Please fiil the field!</div>');
				   err=true;
                  }
				  if(!err){
					  var $length = '#length_'+$i;
						var $width = '#width_'+$i;
						var $item_id= '#item_total_'+$i;
						var $temp = $($length).val()*$($width).val();
						$($item_id).html($temp); 
						 $calarea +=$temp; 
				}
				  
				  
				  
               }

	
	
		  var $noofpacks = Math.ceil($calarea/$covperpack);
			
		  var $estarea= $noofpacks*$covperpack;
		  var $excarea=$estarea.toFixed(2) - $calarea;
		 var  $excareaPer=$excarea/$calarea*100;
		              
		  $excareaPer=Math.ceil($excareaPer.toFixed(4));
		 
		   $("#exceess_area_percent").html($excareaPer);  
		  $('#total_area').html($calarea);
		  $("#no_of_packs").html($noofpacks);
			/*for DU1133 TPM and  1.6 area/quantiy */ 
		   var $apq = 1.6;
			var $quantity = Math.ceil($estarea/$apq); 
		}

	
}

/////// confirm calculate square meter ///////////////////

$(document).on('click','#confirm_calc',function(){
	var max_val=$('#cc_Stock_count').val();

	var culc_val=$('#no_of_packs').text();
	if(Number(culc_val)!=0){
	if(Number(max_val)>=Number(culc_val)){
		 var temp_count = $('#cov_per_pack').val();
		  temp_count = Number(temp_count);
		  var cal_quan = Number(culc_val);
		  var total_cov_ret = temp_count*cal_quan;
		$("#quantity-control").val(culc_val);
		$(".coverage_value").html(total_cov_ret);
		jQuery('.underlay .acc_rec_qty').each(function(index,element){
			console.log(element);
			var tmpr = jQuery(element).attr('tpm_ratio');
			jQuery(element).text(Math.ceil(Number(total_cov_ret)/Number(tmpr)));

		});
		
		$("#quantity-control").trigger('change');
		$('#error_max_msg').html('');
		$('.close').trigger('click');
	}else{
		$('#error_max_msg').html('Insufficient stock.');
	}
	}

	
	
});






$(document).on('click','#cal_id',function(){
	"use strict";
     		  calculate_square();

       	});
	
	 $(document).ready(function() {

       

/* to erase the data and added div */


       $(document).on("click",'#cancel_calc',function(){
                    
			$('.cc-void-field').remove();
             
       $("#exceess_area_percent").html('');
        $('#total_area').html('');
        $("#no_of_packs").html('');
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
       		 $($item_id).html('');
       		 if($i>=2){
               $rowid = '#row_cal_'+$i;
       		 	 $($rowid).remove();
       		 }
       	
           

	}


       });

	 	 });



