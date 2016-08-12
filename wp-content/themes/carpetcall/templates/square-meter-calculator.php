<div id="myModalcalc" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      

        
            <div class="cc-smc-blk-title">
                <h3 >Square Meter Calculator</h3>
            </div>
        
      </div>
      <div class="modal-body clearfix">
  


            
    
       <?php
       $x = get_field('size_m2',get_the_ID());
       $stock = get_post_meta(get_the_ID(), '_stock', true);
       ?>
            <div class="col-md-12 cc-calculator-sec-r">
            <div class="col-md-6">
                 <input type="hidden" class="form-control" id="cov_per_pack" placeholder="" name="cov_per_pack" value='<?php echo $x ;?>'>
                  <input type="hidden" class="form-control" id="cc_Stock_count" placeholder="" name="cc_Stock_count" value='<?php echo $stock;?>'>
                 </div><div class="col-md-6"></div>
            </div>
        
         
        <div class="calculator_container" id="calculator_container">
        <div class="row" id="row_cal_1">
            <div class="col-md-8 col-item-price">
                <div class="cal_pro" id="cal_pro_1">
                    <div class="container_1">
                        <div class="form-group col-md-6">
                            <div class="col-md-6 no-lr">
                                <label for="width_1">Room 1</label>
                            </div>
                            <div class="col-md-6 no-lr">
                                <input type="text" class="form-control" id="width_1" placeholder=" Width (m)" name="width_1" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="col-md-6 no-lr">
                                <label for="length_1"></label>
                            </div>
                            <div class="col-md-6 no-lr">
                                <input type="text" class="form-control" id="length_1" placeholder="Length (m)" name="length_1" required>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="col-md-4 ">

                
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control col-md-8 item_indivisual_total" id="item_total_1" placeholder="" name="item_total_1" readonly>
                        </div>
                        
                   
            </div>

        </div></div>
    
<div class="row">
 <div class="form-group col-md-8 col-item-price">
                    <button type="button" class="btn btn-default" id="cal_more">+Add Rooms</button>
                    <button type="submit" class="btn btn-default" id="cal_id" >Calculate</button>
                </div><div class="form-group col-md-4 "></div> </div>
                </form>

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


<div class="clearfix"></div>
<div class="row">
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
</div>
            
            
      </div>
      
    </div>

  </div>
</div>
