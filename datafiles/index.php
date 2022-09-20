<?php
    include("../db/config.php");
    $dbobjx = new Database;
    //==============================Random Password==============================
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    //==============================Random Password==============================
    //==============================Generating Salt==============================
    function generatingSalt(){
        $salt = password_hash('Whatawonderfulday', PASSWORD_DEFAULT);
        return $salt;
    }
    //==============================Generating Salt==============================
    //==============================Encrypt String==============================
    function encryptString($salt,$password){
        $saltedpass = $password . $salt;
        $hashpassword = hash('sha256', $saltedpass);
        return $hashpassword;
    }
    //==============================Encrypt String==============================
    //==============================Curl Function==============================
    function curlFunction($url,$data,$headers = "",$userpwd = "",$type = ""){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        if($headers != ""){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if($userpwd != ""){
            curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        }
        if($type == "PUT"){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        }else if($type != ""){
            curl_setopt($ch, CURLOPT_POST, 0);
        }else{
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($ch, CURLOPT_ENCODING,'');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_MAXREDIRS,10);
        curl_setopt($ch,CURLOPT_TIMEOUT, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close ($ch);
        if($err){
            return $err;
        }else{
            return $result;
        }
    }
    //==============================Curl Function==============================
    //==============================Curl Function Revised==============================
    function curlFunction_revised($url,$data,$headers = "",$type = ""){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $type,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
       
        if(($httpcode == 200)){
            echo response("1","Success",$response);
           
        }else{
            echo response("0","Failed",$response);
        }
    }
    //==============================Curl Function Revised==============================
   //==============================Get Tokens From APi==============================
   function getToken(){
    $url = API_URL.'Accounts/GetToken';
    $headers = array(
        "Content-type: application/json",
        "XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht"
    );
    $request = array(
        "mail"      => "support@outlanderz.de",
        "password"  => "fBsAtCr6Lm0jhD9FKlYMRPpW1"
    );
    $return = curlFunction($url,json_encode($request),$headers);
    $clean_token=str_replace('"','',$return);
    return $clean_token;
}
//==============================Get Tokens From APi==============================
    //==============================Encrypt==============================
    function encryption($string){
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';         
        $encryption_key = "GeeksforGeeks";         
        $encryption = openssl_encrypt($string, $ciphering,
        $encryption_key, $options, $encryption_iv);
        return $encryption;
    }
    //==============================Encrypt==============================
    //==============================Decrypt==============================
    function decryption($string){
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = "GeeksforGeeks";
        $decryption = openssl_decrypt($string, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }
    //==============================Decrypt==============================
    //==============================Send Mail==============================
    function sendMail($to,$subject,$body,$cc=""){
        include "../library/phpmailer/class.phpmailer.php";
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = "";
        $mail->Port = 25;
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = false;
        $mail->SetFrom('info@test.com', "test");
        $mail->Timeout = 3600;
        if ($cc!="") {
            $mail->addCC($cc);
        }
        $mail->Subject = $subject;
        $mail->AddAddress($to);
        $mail->MsgHTML($body);
        $sent = $mail->Send();
        $return = array(
            'status'=> ($sent)?1:0,
            'response'=>$sent
        );
        return json_encode($return);
    }
    //==============================Send Mail==============================
    //==============================response Function==============================
    function response($status , $message , $payload = array()){
        $data = array(
            "status"=>$status,
            "message"=>$message,
            "payload"=>$payload 
        );
        return json_encode($data);
    }
    //==============================Clean String==============================
    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
            '/&/'           =>   'And', // &
            "/'/"           =>   '`', // &
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }
    //==============================Clean String==============================