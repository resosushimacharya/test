<?php
/*
* Template Name: csvfile
*/


$filename = site_url().'/productfiles/ACTRUGOLS.csv';
$file = fopen($filename,"r");
$count_csv = 0;
$arraycsv = array();
while(! feof($file))
  {
$arraycsv[] =fgetcsv($file);
$count_csv++;
  }
 fclose($file); 

$arraycsvf = array();

$arraycsvKey= array();
$control=1;
$arraycsvff = array();
$arraycsvffc = array();
foreach($arraycsv as $arraycsvu){
 

		
			$arraycsvf[]=$arraycsvu;



		$arraycsvff[$arraycsvu[1]]=$arraycsv;
       $arraycsvffc[$arraycsvu[1]]=$arraycsvf;

	$control++;


}
do_action('pr',$arraycsvff);
$testarray[]=array(4,6);
foreach($arraycsvff as $srckey=>$srcvalue){
  echo $srckey;
  
  foreach($arraycsvffc as $deskey=>$desvalue){
  echo $deskey;
  if($deskey==$srckey){
    echo "hello";
    do_action('pr',$desvalue);
  }
  //do_action('pr',$src);
}
}
die;
do_action('pr',$arraycsvff);
do_action('pr',$arraycsvffc);

$tempvar = 'Range';
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





?>


