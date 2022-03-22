<?php
$url= "http://convert.nicn.gov.ng/coopapi.php";

$data1='{
 "year" : "2018",
 "month": "January"
}';

 
 
  $ch = curl_init($url);
  $headers = array(
      'Content-Type: application/json'
     
    );
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
  //
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, 1); 
  $ksksk= curl_exec($ch);
  //$return = curl_exec($process);
curl_close($ch);
//return $return; 
  
  
Die("kdkdkd".$ksksk);

$data_string='{
 "year" : "2018",
 "month": "January"
}';
$crl = curl_init();
//$url= "https://sales.ringo.ng/api/auth";
curl_setopt($crl, CURLOPT_URL, $url);
$headr = array();
$headr[] = 'Content-length: '. strlen($data_string);
$headr[] = 'Content-type: application/json';
$headr[] = 'Method: POST';

curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
curl_setopt($crl, CURLOPT_POST,true);
$rest = curl_exec($crl);

$restcurl_close($crl);

print_r($rest);

die();

$ch = curl_init($url);
$data2='{
 "year" : "2018",
 "month": "January"
}';
 $options = array(
  'http' => array(
    'method'  => 'POST',
    'content' => $data2,
    'header'=>  "Content-Type: application/json\r\n" 
                
    )
);
$context  = stream_context_create( $options );
$result = file_get_contents( $url, true, $context );
echo $result;;
?> 