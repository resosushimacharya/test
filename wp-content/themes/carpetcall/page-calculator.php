<?php /* * Template Name: calculator */ get_header(); ?>

<style>
	 .col-item-price{ border-right: 1px solid #ccc; }
	/* .col-total-item-section{border-right: 1px solid #ccc;} */
	.item_indivisual_total{background: #ccc;}
	.col-result-input{background: #ccc;}
</style>
<div class="container clearfix">
<div class="inerblock_serc">
<div class="container">
    
        <div class="row">
            <div class="col-md-12">
                <h3 style="text-align:center;background-color:#ccc">Square Meter Calculator</h3>
            </div>
        </div>
        <br>
       <div class="row">
            <div class="col-md-12"><div class="col-md-2">
            <label for="cov_per_pack">Enter Coverage Per Pack</label></div>
            <div class="col-md-2">
                 <input type="text" class="form-control" id="cov_per_pack" placeholder="" name="cov_per_pack">
                 </div><div class="col-md-3">
            	sqm/pack
            </div>
            </div>
        </div>
         <br>
        <div class="calculator_container" id="calculator_container">
        <div class="row" id="row_cal_1">
            <div class="col-md-8 col-item-price">
                <div class="cal_pro" id="cal_pro_1">
                    <div class="container_1">
                        <div class="form-group col-md-6">
                            <div class="col-md-6">
                                <label for="width_1">Room 1 Width(m)</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="width_1" placeholder="" name="width_1">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="col-md-6">
                                <label for="length_1">Length(m)</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="length_1" placeholder="" name="length_1">
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="col-md-4 ">

                
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control col-md-8 item_indivisual_total" id="item_total_1" placeholder="" name="item_total_1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            m<sup>2</sup>
                        </div>
                   
            </div>

        </div></div>
    
</div><div class="container"><div class="row">
 <div class="form-group col-md-8 col-item-price">
                    <button type="button" class="btn btn-default" id="cal_more">+Add Rooms</button>
                    <button type="submit" class="btn btn-default" id="cal_id" >Calculate</button>
                </div><div class="form-group col-md-4 "></div> </div> </div>
<div class="container">
    <div class="row"><div class="form-group col-md-8 col-item-price">
        <p class="pull-right">Excess</p>
    </div>
    <div class="col-md-4 col-total-item-section">
        <div class="form-group col-md-8 ">
            <input type="text" class="form-control col-result-input" id="exceess_area_percent" placeholder="" readonly>
        </div>
        <div class="form-group col-md-4">
            %</div>
    </div>
    </div><div class="row">
    <div class="form-group col-md-8  col-item-price ">
        <p class="pull-right">Total m
            <Sup>2</Sup>
        </p>
    </div>
    <div class="col-md-4 col-total-item-section">
        <div class="form-group col-md-8">
            <input type="text" class="form-control col-result-input" id="total_area" placeholder="" name="total_area" readonly>
        </div>
        <div class="form-group col-md-4">
            m
            <Sup>2</Sup>
        </div>
    </div>
    </div><div class="row">
    <div class="form-group col-md-8 col-item-price ">
        <p class="pull-right">Total Packs Required</p>
    </div>
    <div class="col-md-4 col-total-item-section">
        <div class="form-group col-md-8">
            <input type="text" class="form-control col-result-input" id="no_of_packs" placeholder="" readonly>
        </div>
    </div>
    </div>
</div>
</div>
</div><div class="clearfix"></div>
<div class="container"><div class="row">
	<div class="col-md-6 ">
		<button class="btn btn-default pull-right" type="button" id="cancel_calc"  >
       Cancel
        </button>
	</div>
	<div class="col-md-6">
		<button class="btn btn-default" type="button" id="confirm_calc" >
      Confirm
        </button>
	</div>
</div></div>

<?php get_footer();
  