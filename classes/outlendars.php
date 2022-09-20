<?php
require("outlendarsconfig.php");
defined('API_URL') ? NULL : define('API_URL', 'https://outlanderzwebappapi.azurewebsites.net/api/');
defined('XApiKey') ? NULL : define('XApiKey', 'XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht');
Class Outlendars extends outlendarsConfig{
    //==============================Get Tokens From APi==============================
    public function getToken() {
        $url = API_URL . 'Accounts/GetToken';
        $headers = array(
            "Content-type: application/json",
            "XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht",
        );
        $request = array(
            "mail" => "nihal40khan@gmail.com",
            "password" => "Every.100@100",
        );
        $return = curlFunction($url, json_encode($request), $headers);
        return $return;
    }
    //==============================Get Tokens From APi==============================
    public function getAPIcontent($file_name,$data){
        $json = json_encode($data);
        $response = $this->GET_API_CONTENT($file_name, $json);
        $result = json_decode($response);
        return $result;
    }
    public function getRegion(){
        $data = array(
            'requestType'=>'get_region',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function getActivities(){
        $data = array(
            'requestType'=>'get_activities',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function getPlaces(){
        $data = array(
            'requestType'=>'get_places',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function getCalculation(){
        $data = array(
            'requestType'=>'get_calculation',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function getWeekdays(){
        $data = array(
            'requestType'=>'get_weekDays',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function getPaymentLocation(){
        $data = array(
            'requestType'=>'get_paymentLocation',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function checkUrlPermissions(){
        $data = array(
            'requestType'=>'checkUrlPermissions',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function offerCounter($package){
        $counter = 4;
        if($package == "FREE"){
            return ($counter > 0)? false: true;
        }
    }
    public function getCurrentUser(){
        $data = array(
            'id'=>$_SESSION["userid"],
            'requestType'=>'getUsers',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function paymentInfo(){
        $result = $this->getCurrentUser();
        $itemName = "Demo Product";
        $itemNumber = "PN12345";
        $itemPrice = $result->payload->charge_amount;
        $taxes = (10 / 100) * $itemPrice;
        $currency = "USD";
        $return = [
            'itemName' => $itemName,
            'itemNumber'=>  $itemNumber,
            'itemPrice'=>  $itemPrice,
            'taxes'=>  $taxes,
            'currency'=>  $currency,
        ];
        return $return;
    }
    public function transactions(){
        $data = array(
            'id'=>$_SESSION["userid"],
            'requestType'=>'transactions',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function singleTransaction($id){
        $data = array(
            'id'=>$_SESSION["userid"],
            'recordId'=>$id,
            'requestType'=>'singleTransaction',
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function checkUserDB(){
     $data = array(
         'id'=>$_SESSION["userid"],
         'requestType'=>'checkUserDB',
     );
     return $this->getAPIcontent('getRelationPax',$data);
    }
    public function getOffers(){
        $data = array('requestType'=>'getOffers');
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function addOffers(){
        $data = array('requestType'=>'addOffer');
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function deleteOffer($id){
        $data = array(
            'id'=>$id,
            'requestType'=>'deleteOffer'
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function getEquipement(){
        $data = array('requestType'=>'getEquipement');
        return $this->getAPIcontent('getRelationPax',$data);
    }
    public function addEquipement($name){
        $data = array(
            'name'=>$name,
            'requestType'=>'addEquipement'
        );
        return $this->getAPIcontent('getRelationPax',$data);
    }
}