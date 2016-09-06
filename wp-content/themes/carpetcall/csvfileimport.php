<?php
/*
* Template Name: csvfile
*/



function cc_csv_conv_array($filename){
$filename = site_url().'/productfiles/'.$filename;
$file = fopen($filename,"r");
$count_csv = 0;
$arraycsv = array();
while(! feof($file))
{
$arraycsv[] =fgetcsv($file);
$count_csv++;
}
fclose($file); 
$arraycsvff = array();
foreach($arraycsv as $arraycsvu){
$arraycsvff[$arraycsvu[1]]=$arraycsvu;
}
return  $arraycsvff;
}


/////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////csv file reads ///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

$url = site_url();
$url = explode('/',$url);
$countfileslen = 2;
$counter=1;
$rugfilesearray =array();
$hardfloorfilesarray = array();
$errorfilesarray = array();
$errorflag = false;
// to write a file and save in folder 
$time = current_time('mysql');

if(strcasecmp($url[2],'localhost')==0){
    $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/history/';}
else{
    $desfolder= $_SERVER['DOCUMENT_ROOT'].'/history/';
}
$time =  current_time('Y-m-d-m-h-s');
$newfilename = $desfolder.'log'.$time.'.txt';



if(strcasecmp($url[2],'localhost')==0){
    $directory = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/productfiles';}
else{
    $directory = $_SERVER['DOCUMENT_ROOT'].'/productfiles';
}

$csc_rugs_flag=$csc_hardfloor_flag=false;

$rugs_post_ids= $hard_post_ids=array();
$filecols = array_diff(scandir($directory), array('..', '.'));
foreach($filecols as $fileitem){
    if (strpos(strtolower($fileitem), 'rugols') !== false) {
        $fileextension = explode('.',$fileitem);
        if($fileextension[1]=='csv'){
        //$rugfilesearray[] = $fileitem ;
            $rugs_post_ids[]=cc_csv_conv_array($fileitem );
            $csc_rugs_flag=true;
        }
        else{
            echo "undefined file($fileitem) for rugs.";
        }

    }
    elseif(strpos(strtolower($fileitem), 'lols') !== false){
        $fileextension = explode('.',$fileitem);
        if($fileextension[1]=='csv'){
            //$hardfloorfilesarray[] = $fileitem;
            $hards_post_ids[]=cc_csv_conv_array( $fileitem);
            $csc_hardfloor_flag=true;
        }
        else{
            echo "undefined file($fileitem) for hardflooring.";
        }
    }
    else{
        $errorfilesarray[] = $fileitem;
        $errorflag = true;
    }
} 
if($csc_hardfloor_flag){
cc_res_csv_hards($hards_post_ids,'NETLOLS');}



if($csc_rugs_flag){
cc_res_csv_rugs($rugs_post_ids,'NETRUGOLS');}
function cc_res_csv_rugs ( $rugs_post_ids,$filename ) {

    $new_rugs_ids=array();
    foreach($rugs_post_ids as $rugs_ids){

        foreach($rugs_ids as $rugs){
            if(strcasecmp($rugs[0],'state')==0){
                continue;
            }

            if(array_key_exists($rugs[1],$new_rugs_ids)){
                $old_item=$new_rugs_ids[$rugs[1]];
                $qty= intval($old_item[13])+intval($rugs[13]);
                $old_item[13]=$qty;
                $new_rugs_ids[$rugs[1]]=$old_item;

            }else{
                $new_rugs_ids[$rugs[1]]=$rugs;
            }


      }

    }
    $url = site_url();
    $url = explode('/',$url);
    if(strcasecmp($url[2],'localhost')==0){
        $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/netcsvs/';
    }else{
        $desfolder= $_SERVER['DOCUMENT_ROOT'].'/netcsvs/';
    }
        $time =  current_time('Y-m-d-m-h-s');

    $fp = fopen($desfolder.$filename.$time.'.csv', 'w');
    foreach($new_rugs_ids as $writeline){
        fputcsv($fp, $writeline);

    }
    fclose($fp);

    do_action('pr',$new_rugs_ids); 

    do_action('pr',$rugs_post_ids); 

}

function cc_res_csv_hards($hards_post_ids,$filename){ 
     $new_hards_ids=array();
      foreach($hards_post_ids as $hards_ids){

          foreach($hards_ids as $hards){
              if(strcasecmp($hards[0],'state')==0){
                  continue;
              }

              if(array_key_exists($hards[1],$new_hards_ids)){
                  $old_item=$new_hards_ids[$hards[1]];
                  $qty= intval($old_item[2])+intval($hards[2]);
                  $old_item[2]=$qty;
                  $new_hards_ids[$hards[2]]=$old_item;

              }else{
                  $new_hards_ids[$hards[2]]=$hards;
              }


        }

      }
      $url = site_url();
      $url = explode('/',$url);
      if(strcasecmp($url[2],'localhost')==0){
          $desfolder = $_SERVER['DOCUMENT_ROOT'].'/carpetcall/netcsvs/';
      }else{
          $desfolder= $_SERVER['DOCUMENT_ROOT'].'/netcsvs/';
      }
          $time =  current_time('Y-m-d-m-h-s');

      $fp = fopen($desfolder.$filename.$time.'.csv', 'w');
      foreach($new_hards_ids as $writeline){
          fputcsv($fp, $writeline);

      }
      fclose($fp);

      do_action('pr',$new_rugs_ids); 

      do_action('pr',$rugs_post_ids); 

}







?>


