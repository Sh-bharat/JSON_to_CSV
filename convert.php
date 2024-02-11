<?php 
 
 ini_set('memory_limit', '-1');
$str = file_get_contents('temp.json');

function printnow($str ,$pvs,$status) {
    
    $jsonans = json_decode($str, true);
    $col="";
    foreach ($jsonans as $key => $value)
    {   
        $key = preg_replace('/\d/', '', $key );
        if($pvs!=""){$temp=$pvs."~".$key;}
        else{ $temp=$pvs."".$key;}
        if(is_null($value) ){$value="";}
        elseif( is_null($key)){$key="";}
        if(! is_array($value)){$col=$col.('"'.$temp.'":"'.$value.'"'.' ');}
        
        else{
            $string = json_encode($value);
            if($pvs!=""){
            $col=$col.printnow($string,$pvs."~".$key,$status+1);}
            else{$col=$col.printnow($string,$key,$status+1);}
            }
    }
    if($status==1){
    $col=str_replace('" "','","',$col);
    $col="{".$col."}";
    echo nl2br("successfull"."\n\r".substr_count($col,","));

    $file_pointer=fopen("dataset.csv","a");
    // echo nl2br($col,"\n\r");
    $jsonans = json_decode(utf8_encode(preg_replace('/[\x00-\x1F\x80-\xFF]/','',$col)), true);
    // $jsonans = json_decode($col, true);
    fputcsv($file_pointer,$jsonans);
    // if(!is_null($jsonans)){fputcsv($file_pointer,$jsonans);}
    // else{ echo "2222 -----------------------------------------"; }
    fclose($file_pointer); 

}
else{
   return $col;}


    }
    
printnow($str,"",0);


?> 


