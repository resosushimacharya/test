<?php
/*
* Template Name: csvfile
*/

$filename = get_template_directory_uri().'/csv/Datawithheaders.csv';
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
 
fclose($file);
?>