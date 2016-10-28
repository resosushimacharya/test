/* this is script for calculator section of product in store */

$ = jQuery.noConflict();
    $(document).ready(function() {
        $("#cal_more").click(function() {
        		var count = $("#calculator_container>div").length;
        		counts = count - 1;
        		 jQuery('#calculator_container .row').each(function(index,element){
        		 	if(index==counts){
        		 		 var Id = $(element).attr('id');
        		 		  var lastCount =  Id.split("_");
        		 		  lastCount = lastCount[2];
        		 		 count = Number(lastCount);
        		 	}
        		  });
        		count = count + 1;
             /* $("#calculator_container").append('<div class="row" id="row_cal_'+count+'"> <div class="col-md-8 col-item-price"><div class="cal_pro" id="cal_pro_'+count+'"> <div class="container_'+count+'"><div class="form-group col-md-6"> <div class="col-md-6"> <label for="width_'+count+'">Room '+count+' Width(m)</label> </div> <div class="col-md-6"> <input type="text" class="form-control" id="width_'+count+'" placeholder="" name="width_'+count+'"> </div> </div> <div class="form-group col-md-6"> <div class="col-md-6"> <label for="legth_'+count+'">Length(m)</label> </div> <div class="col-md-6"> <input type="text" class="form-control" id="length_'+count+'" placeholder="" name="length_'+count
              	+'"> </div> </div> </div> </div> </div> <div class="col-md-4 "> <div class="form-group col-md-8"> <input type="text" class="form-control col-md-8 item_indivisual_total" id="item_total_'+count
              	+'" placeholder="" name="item_total_'+count
              	+'" readonly> </div> <div class="form-group col-md-4"> m<sup>2</sup> </div> </div> </div> ');
				*/
			var $html="";	
		$html+='<div class="row single-room-sec" id="row_cal_'+count+'">';
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
                        $html+='<div class="form-group col-md-6 for-length">';
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
		if(jQuery('#calculator_container').find('.calculated').length>0){
			calculate_square();
		}
		
		
	});
	
	
	////////// check number value //////////////
	function number_check(value){

		if($(document).find('#error_max_msg').length){
			$('#error_max_msg').hide();
		}
		
		var number = /^[0-9.]+$/.test(value);
	
		var dotCount = value.split(".").length - 1;
		
		 if(dotCount<=1 && number){
		 	
		  	return true;
		 
		  	
		
		  }
		  else{
		  			return false;
		  }
		            

	}
	
	
	
	//////////////////////// calulater number error validate//////////////////
	$(document).on('keyup','.width_check', function(){
		
		$(this).siblings('.cc-void-field').remove();
		
		if($(this).val()===""){
		  $(this).parent().append('<div class="cc-void-field">Please enter width.</div>');
		}else if(!number_check($(this).val())){
			  if(Number($(this).val())<0){
			     	 $(this).parent().append('<div class="cc-void-field">Please enter positive number only.</div>');
			}
			 else{
			 	 $(this).parent().append('<div class="cc-void-field">Please enter number only.</div>');
			 }
		}
		
	});
	$(document).on('keyup','.length_check', function(){
		
		$(this).siblings('.cc-void-field').remove();
		
		if($(this).val()===""){
		  $(this).parent().append('<div class="cc-void-field">Please enter length.</div>');
		}else if(!number_check($(this).val())){
			     if(Number($(this).val())<0){
			     	 $(this).parent().append('<div class="cc-void-field">Please enter positive number only.</div>');
			}
			 else{
			 	 $(this).parent().append('<div class="cc-void-field">Please enter number only.</div>');
			 }

		}
		
	});
function calculate_square(){
		
		jQuery('#confirm_calc').attr('data-dismiss','');
	
	/*alert($("#calculator_container>div").length);*/
       	var $loop =$("#calculator_container>div").length;
        var  $calarea = 0;
		 var err=false;
       	/*alert($loop);*/
       	var $covperpack =$('#cov_per_pack').val();
      
			    
          
        jQuery('#calculator_container .row').each(function(index,element){
            	err=false;
       		       if(jQuery(element).find('.length_check').val()==''){
                    var myid =jQuery(element).find('.length_check');
					$(myid).parent().find('.cc-void-field').remove();
                    $(myid).parent().append('<div class="cc-void-field">Please enter length.</div>');
					err=true;
                   }
				  if(jQuery(element).find('.width_check').val()==''){
                    var  myid =jQuery(element).find('.width_check');
					$(myid).parent().find('.cc-void-field').remove();
                    $(myid).parent().append('<div class="cc-void-field">Please enter width.</div>');
				   err=true;
                  }
                 // To add the class in first row element 
                 if(index == 0 ) {
                 	 $(element).addClass("calculated");

                 }
                 if(!err){
       			$temp = Number(jQuery(element).find('.width_check').val())*Number(jQuery(element).find('.length_check').val());
                  $temp = $temp.toFixed(2);
						$temp = Number($temp );
					var item_id =jQuery(element).find('.item_indivisual_total span');
                      if($temp>0){
						$(item_id).html($temp); 

						 $calarea +=$temp;   
						  }
						}
       });
	

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

/////// confirm calculate square meter ///////////////////

$(document).on('click','#confirm_calc',function(){
	var max_val=$('#cc_Stock_count').val();
     $loadref=$('#store-count-quantity').attr('href');
	var culc_val=$('#no_of_packs').text();
	if(Number(culc_val)!=0){
	if(Number(max_val)>=Number(culc_val)){
		jQuery('#confirm_calc').attr('data-dismiss','modal');
		 var temp_count = $('#cov_per_pack').val();
		  temp_count = Number(temp_count);
		  var cal_quan = Number(culc_val);
		  var total_cov_ret = temp_count*cal_quan;
		  total_cov_ret = total_cov_ret.toFixed(2);
		$("#quantity-control").val(culc_val);
		$(".coverage_value").html(total_cov_ret);
		$stoq = $('.cc-quantiy-section  #quantity-control').val(); 
		   var sizem2 = jQuery('#sizem2').val(); 
              if($stoq.toLowerCase()!='please select'){
         $('#store-count-quantity').attr('href',$loadref);

          $('#store-count-quantity').addClass('add_to_cart_button');
           $('#store-count-quantity').addClass('ajax_add_to_cart');
            $(".add_to_cart_button").attr('data-quantity',$stoq);
              $(".add_to_cart_button").data('quantity',$stoq);}
		jQuery('.underlay .acc_rec_qty').each(function(index,element){
			//console.log(element);
			var tmpr = jQuery(element).attr('tpm_ratio');
			var rec_qty = Math.ceil(Number(total_cov_ret)/Number(tmpr));
			jQuery(element).text(rec_qty);
			jQuery(this).parents('.acc_qnty').find('select.qty').val(rec_qty);
			jQuery(this).parents('.acc_qnty').find('select.qty').trigger('change');
		});
		
		$("#quantity-control").trigger('change');
		$('#error_max_msg').html('');
		$('.close').trigger('click');
	}else{
		$('#error_max_msg').show();
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
			if($(document).find('#error_max_msg').length){
			$('#error_max_msg').hide();
		}
		

			$("#exceess_area_percent").html('');
			$('#total_area').html('');
			$("#no_of_packs").html('');
			$loop =$("#calculator_container>div").length;
			$calarea = 0;
			/*alert($loop);*/
			$covperpack = 2.49;


			jQuery('#calculator_container .row ').each(function(index,element){
				if(index!=0){
					$(element).remove();
				}
				else{
					jQuery(element).find('.width_check').val('');
					jQuery(element).find('.length_check').val('');
					jQuery(element).find('.item_indivisual_total span').html('-');
					if(jQuery('#calculator_container').find('.calculated').length>0){
						$(element).removeClass('calculated');}
				}
			});



       });

	 	 });



