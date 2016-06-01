<?php
/*
* Template Name: calculator
*/
get_header();

?>

<br>
<br><div class="container" style="margin-top:150px;">
<div class="col-md-12"><div class="row"><div class="col-md-12">
	<h3 style="text-align:center;background-color:#ccc">Square Meter Calculator</h3>
</div></div>
<br><div class="row">
	<div class="col-md-8">
    <div class="cal_pro" id="cal_pro">
    <div class="container_1">
    <div class="form-group col-md-6">
      <div class="col-md-6"><label for="width">Room 1 width(m)</label></div>
      <div class="col-md-6">
   <input type="text" class="form-control" id="width" placeholder="">
    </div>
    </div>
    <div class="form-group col-md-6">
     <div class="col-md-6"><label for="width">Length(m)</label></div>
     <div class="col-md-6"> <input type="text" class="form-control" id="length" placeholder=""></div>
    </div>
    </div></div>
    <div class="form-group col-md-12">
    <button type="button" class="btn btn-default" id="cal_more">Read More</button>
    <button type="submit" class="btn btn-default">Calculate</button>
    </div>
 </div>
	<div class="col-md-4">

	<div class="item_total_wrapper" id="item_total_wrapper">
	<div class="item_total_1"><div class="form-group col-md-8">
		<input type="text" class="form-control col-md-8" id="width" placeholder=""></div>
<div class="form-group col-md-4">
		%</div>
</div>
	</div>
	</div>
	
</div></div>
</div>
<div class="container">
	<div class="col-md-8">
	<p class="pull-right">Excess</p></div>
	<div class="col-md-4 "> <div class="form-group col-md-8">
		<input type="text" class="form-control" id="width" placeholder=""></div>
		<div class="form-group col-md-4">
		%</div></div>
	<div class="col-md-8 "><p class="pull-right">Total m<Sup>2</Sup></p></div>
	<div class="col-md-4"> <div class="form-group col-md-8">
		<input type="text" class="form-control" id="width" placeholder=""></div>
		<div class="form-group col-md-4">
		m<Sup>2</Sup></div></div>
	<div class="col-md-8 "><p class="pull-right">Total Packs Required</p></div>
	<div class="col-md-4"> <div class="form-group col-md-8">
		<input type="text" class="form-control" id="width" placeholder=""></div></div>
</div>

<script>
$(document).ready(function(){
  $("#cal_more").click(function () {
  	$("#cal_pro>div").length;
  	alert($("#cal_pro>div").length);
      $("#cal_pro").append('<div class="form-group col-md-6"><div class="col-md-6"><label for="width">Room 1 width(m)</label></div><div class="col-md-6"><input type="text" class="form-control" id="width" placeholder=""></div></div><div class="form-group col-md-6"><div class="col-md-6"><label for="width">Length(m)</label></div><div class="col-md-6"> <input type="text" class="form-control" id="length" placeholder=""></div></div>');
    });
  $("#item_total_wrapper").append('<div class="item_total_1"><div class="form-group col-md-8"><input type="text" class="form-control col-md-8" id="width" placeholder=""></div><div class="form-group col-md-4">%</div></div>');
});
</script>
<?php 
get_footer();