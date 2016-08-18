<?php 
  get_header();

  //head-selected
  $nearest = true;

  if(isset($_POST["check-head-id"])) $nearest = false;

?>
<?php
$term =  get_queried_object();

?>
<?php 
    
   $statename = "";
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
    foreach($regions as $key =>$value):
              if(strcasecmp($key,$term->slug)==0){
                $statename = strtoupper($value); 
                $stateTitle = strtoupper($key); 

              }

      endforeach;
?>

<div class="cc-store-hd-title">
  <div class="container">
   <div class="cc-locator-title-sec-z">
   <?php 
     echo '<h4><span class="cc-locator-sub"><a href="'.site_url().'/find-a-store/">'. 'STORE FINDER'.'</a></span>'.'> '. $stateTitle.'</a></span></h4>';
   ?>

</div>
                  <div class="cc-finder-title">
                      <h3><?php echo  $stateTitle;?></h3>
                  </div>
                  <div class="cc-options-wrapper-nh">
                      <form method="post" action="<?php echo site_url();?>/find-a-store">
                      <div class="cc-find-store-au <?php if($nearest) echo ' store-finder-active-tab'; ?>">
                          <input type="hidden" name="check-near-id" value="check near value"/>
                          <input type="submit" id="cc-but-near" class="cc-but-near-con" value="FIND YOUR NEAREST STORE" name="cc-but-near-name"/>
                          </div>
                      </form >
                      <form method="post" action="<?php echo site_url();?>/find-a-store">
                      <div class="cc-find-store-au hf <?php if(!$nearest) echo ' store-finder-active-tab'; ?>">
                          <input type="hidden" name="check-head-id" value="check head value"/>
                          <input type="submit" id="cc-but-head" class="cc-but-head-con" value="HEAD OFFICES" name="cc-but-head-name"/>
                          </div>
                      </form>
                  </div>
    </div>
</div><div class="clearfix"></div>


<div class="cc-store-bdy-contr">
  <div class="container">

<?php echo do_shortcode('[wpsl template="custom"  
]'); ?>



</div>
</div><div class="clearfix"></div>

<style>


#wpsl-stores{
  overflow:visible !important;
}

</style>

<?php get_footer();?>
<script type="text/javascript">
  jQuery( document ).ajaxComplete(function( event, xhr, settings ) {
    console.log( 'testssssssssssssss'); 
  if(settings.url.indexOf('action=store_search') !== -1){
    if(typeof xhr.responseJSON!=="undefined"){

      console.log( xhr.responseJSON.length);
    }
     


  }
});
</script>