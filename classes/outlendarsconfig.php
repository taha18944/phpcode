<?php
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protocol = 'https://';
}else {
  $protocol = 'http://';
}
$baseUrl = $protocol.$_SERVER['SERVER_NAME'];
defined('BASE_URL') ? NULL : define('BASE_URL', $baseUrl);

Class outlendarsConfig {
  function GET_API_CONTENT($file_name, $json ) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL.'/api/'.$file_name,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS =>$json,
    ));
    $result = curl_exec($curl);
    return $result;
  }
}