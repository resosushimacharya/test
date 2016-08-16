<?php 
/* Template Name: hard floor */

$filename = get_template_directory_uri().'/csv/QTLOLS.csv';
$file = fopen($filename,"r");
$count_csv = 0;
$arraycsv = array();
while(! feof($file))
  {
$arraycsv[] =fgetcsv($file);
$count_csv++;
  }
  
echo $count_csv;
$arraycsvf = array();
//do_action('pr',$arraycsv);
$arraycsvKey= array();
$control=1;
$arraycsvff = array();
foreach($arraycsv as $arraycsvu){
	if($control==1){
      foreach($arraycsvu as $val){
      	$arraycsvKey[]=$val;
      }

	}
	else{
		for($i=0;$i<count($arraycsvu);$i++){
			$arraycsvf[$arraycsvKey[$i]]=$arraycsvu[$i];

		}
		$arraycsvff[]=$arraycsvf;

	}
	$control++;


}

$testarray[]=array(4,6);
do_action('pr',$arraycsvff);
/*$tempvar = 'Range';
$tempex = 'size';
$tempfil = array();
$myarray = array();
foreach($arraycsvff as $test)
{
$tempfil[] =  $test[$tempvar];
$myarray[]=$test['Category'].$test['Range'];
  $hhh=$test['Size'];
  $hh=explode(' ',$hhh);
  $hh[0];
 $width= str_replace("cm","","$hh[0]");
  $length= str_replace("cm","","$hh[2]");
  $height =$hh[10];
  echo  'hello width'.$width.'hello width'.$length.'hello height'.$height;
  
  //do_action('pr',$hlw);
  do_action('pr',$hh);
}

 //do_action('pr',$tempfil);
 do_action('pr',array_count_values($myarray));
 //do_action('pr',array_count_values($tempfil));
 //echo count(array_count_values($tempfil));
 do_action('pr',array_count_values($myarray)); 
fclose($file);

$args=array('post_type' => 'product', 'posts_per_page'=>'-1');
$pro = new WP_Query($args);
while($pro->have_posts()):
 $pro->the_post();
the_title();
$prodis=get_post_meta($post->ID);
    do_action('pr',$prodis);
	endwhile;*/