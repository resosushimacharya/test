<?php get_header();?>
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

                }

        endforeach;
     ?>
<div class="container clearfix">
<div class="inerblock_serc">
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php 
  echo '<h4><span class="cc-locator-sub"><a href="'.site_url().'/find-a-store/">'. 'find a store'.'</a></span>'.'>'.'<span class="cc-locator-root"><a href="'.site_url().'/find-a-store/'.$term->slug.'">'. $statename.'</a></span></h4>';?>

</div>
<?php echo do_shortcode('[wpsl template="custom" category="'.$term->slug.'" 
]'); ?>



</div>
</div><div class="clearfix"></div>

<style>


#wpsl-stores{
  overflow:visible !important;
}

</style>

<?php get_footer();?>