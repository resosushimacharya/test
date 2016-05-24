<?php
/*
* Template Name: csvfile
*/

$filename = get_template_directory_uri().'/csv/Datawithheaders.csv';
$file = fopen($filename,"r");

while(! feof($file))
  {
echo do_action('pr',(fgetcsv($file)));
  }

fclose($file);
?>