<?php
    include ("../datafiles/index.php");
    include ("../db/define.php");
    $request = json_decode(file_get_contents('php://input'));
    switch ($request->requestType) {
        case ('getUsers'):
            $id = $request->id;
            $query = "SELECT * FROM users WHERE id = '$id' AND is_deleted='N'";
            $dbobjx->query($query);
            echo response("1","Success",$dbobjx->single());
        break;
        case ('transactions'):
            $id = $request->id;
            $paymentQuery = "SELECT * FROM transactions WHERE user_id = '$id'";
            $dbobjx->query($paymentQuery);
            echo response("1","Success",$dbobjx->resultSet());
        break;
        case ('singleTransaction'):
            $id = $request->id;
            $singleTransaction = "SELECT * FROM transactions WHERE user_id = '$id' AND id = '$request->recordId'";
            $dbobjx->query($singleTransaction);
            echo response("1","Success",$dbobjx->single());
        break;
        case ('checkUrlPermissions'):
            $role_id=$_SESSION['role_id'];
            $sql2="SELECT * FROM `internal_functions` where role_id='$role_id'";
            $dbobjx->query($sql2);
            $resultM2 = $dbobjx->resultset();
            if($dbobjx->rowCount() > 0 ){
                $_SESSION['internal_functions']=$resultM2;
                echo response("1","Success",$resultM2);
            }
        break;
        case ('checkUserDB'):
            $status = '1';
            $id = $request->id;
            $query = "SELECT * FROM users WHERE id = '$id'";
            $dbobjx->query($query);
            if ($dbobjx->single() == false) {
                $status = '0';
                session_start();
                session_destroy();
            }
            echo response($status,"Success","User Checked");
        break;
        case ('get_paymentLocation'):
            $token = getToken();
            $url = API_URL.'/PaymentLocation';
            $headers = array(
                "Content-type: application/json",
                "XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht",
                "Authorization: Bearer ".$token
            );
            $return = curlFunction($url,"",$headers,"",'GET');
            if(is_null($return)){
                echo response("0","Error in Payment Location API",[]);
            }else{
                echo response("1","Payment locations",$return);
            }
        break;
        case ('get_activities'):
            $token = getToken();
            $url = API_URL.'/Activities';
            $headers = array(
                "Content-type: application/json",
                "XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht",
                "Authorization: Bearer ".$token
            );
            $return = curlFunction($url,"",$headers,"",'GET');
            if(is_null($return)){
                echo response("0","Error in Activities API",[]);
            }else{
                echo response("1","Activities",$return);
            }
        break;
        case ('get_places'):
            $token = getToken();
            $url = API_URL.'/Places';
            $headers = array(
                "Content-type: application/json",
                "XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht",
                "Authorization: Bearer ".$token
            );
            $return = curlFunction($url,"",$headers,"",'GET');
            if(is_null($return)){
                echo response("0","Error in Places API",[]);
            }else{
                echo response("1","Places",$return);
            }
        break;
        case ('get_calculation'):
            $token = getToken();
            $url = API_URL.'/CalculationBasis';
            $headers = array(
                "Content-type: application/json",
                "XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht",
                "Authorization: Bearer ".$token
            );
            $return = curlFunction($url,"",$headers,"",'GET');
            if((is_null($return))){
                echo response("0","Error in CalculationBasis API",$return);
            }else{
                echo response("1","Calculation Basis",$return);
            }
        break;
        case ('get_weekDays'):
            $token = getToken();
            $url = API_URL.'/DayOfWeek';
            $headers = array(
                "Content-type: application/json",
                "XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht",
                "Authorization: Bearer ".$token
            );
            $return = curlFunction($url,"",$headers,"",'GET');
            if((is_null($return))){
                echo response("0","Error in WeekDays API",$return);
            }else{
                echo response("1","Week Days",$return);
            }
        break;
        case ('getOffers'):
            $token = getToken();
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => API_URL.'/Offers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>'{}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht',
                'Authorization: Bearer '.$token
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            if((is_null($response))){
                echo response("0","Error in Offers API",$response);
            }else{
                echo response("1","Offers",$response);
            }
		break;
        case ('addOffer'):
        //     $activity = $_POST['activity'];
        //     $token=getToken();

        //     $curl = curl_init();

        //     curl_setopt_array($curl, array(
        //       CURLOPT_URL => 'https://outlanderzwebappapi.azurewebsites.net//api/Images',
        //       CURLOPT_RETURNTRANSFER => true,
        //       CURLOPT_ENCODING => '',
        //       CURLOPT_MAXREDIRS => 10,
        //       CURLOPT_TIMEOUT => 0,
        //       CURLOPT_FOLLOWLOCATION => true,
        //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => 'POST',
        //       CURLOPT_POSTFIELDS => array('activityId' => $activity,'image'=> new CURLFILE('/C:/Users/pro-tech/Downloads/SampleJPGImage_2mbmb.jpg')),
        //       CURLOPT_HTTPHEADER => array(
        //         'Content-Type: multipart/form-data',
        //         'Accept: application/json',
        //         'Authorization: Bearer '.$token
        //       ),
        //     ));

        //     $response = curl_exec($curl);

        //     curl_close($curl);
        //     echo $response;

            $name = $_POST['userName'];
            $my_file = $_POST['my_file'];
            $description = $_POST['description'];
            $validFrom = $_POST['validFrom'];
            $validTo = $_POST['validTo'];
            $price_without_tax = $_POST['price_without_tax'];
            $vat = $_POST['vat'];
            $calculated_by = $_POST['calculated_by'];
            $price_array=array("value"=>$price_without_tax,"calculationBasis"=>$calculated_by,"vat"=>$vat);
            $payment_location = $_POST['payment_location'];
            $cancelation_time = $_POST['web_url'];
            $cashCheck = $_POST['cashCheck'];
            $cashcredicard = $_POST['cashcredicard'];
            $cashBank = $_POST['cashBank'];
            $min_att = $_POST['min_att'];
            $max_att = $_POST['max_att'];
            $reservationReqCheck = $_POST['reservationReqCheck'];
            $day = $_POST['day'];
            $fromTime = $_POST['fromTime'];
            $toTime = $_POST['toTime'];
            $time_slot = array("start_time"=>$fromTime,"end_time"=>$toTime, "day"=>$day);
            $place = $_POST['place'];


            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => API_URL.'/Offers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "name": "'.$name.'",
                "activityId": '.$activity.',
                "regionId": 2,
                "description": "'.$description.'",
                "validFrom": "'.$validFrom.'",
                "validTo": "'.$validTo.'",
                "price": {
                    "value": '.$price_without_tax.',
                    "calculationBasisId": '.$calculated_by.',
                    "vat": '.$vat.'
                },
                "timeSlots": [
                  {
                    "startTime": "1990-11-08T00:32:56.781Z",
                    "endTime": "1967-06-17T07:31:10.146Z",
                    "day": 2
                  },
                  {
                    "startTime": "1975-05-22T17:38:13.255Z",
                    "endTime": "2013-12-14T17:08:23.969Z",
                    "day": 0
                  }
                ],
                "equipmentIds": [
                  60084925,
                  -21630800
                ],
                "paymentLocation": '.$payment_location.',
                "cancelationTime": '.$cancelation_time.',
                "acceptCash": true,
                "acceptDebitCard": false,
                "acceptCreditCard": false,
                "minAttendees": '.$min_att.',
                "maxAttendees": '.$max_att.',
                "reservationRequestRequired": false,
                "placeId": 9,
                "imageId": 2
              }',
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/json',
                  'Accept: application/json',
                  'XApiKey: '.XApiKey,
                  'Authorization: Bearer '.$token
                ),
              ));

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if((is_null($response))){
                echo response("0","Error in Offers API",$response);
            }else{
                echo response("1","Offer Created Successfully",$response);
            }
        break;
        case ('deleteOffer'):
            $id = $request->id;
            $token = getToken();

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => API_URL.'/Offers/'.$id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_HTTPHEADER => array(
                    'XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht',
                    'Authorization: Bearer '.$token
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            if((is_null($response))){
                echo response("0","Error in Offer Delete API",$response);
            }else{
                echo response("1","Offer Delete Successfully",$response);
            }
        break;
        case ('getEquipement'):
            $curl = curl_init();
            $token = getToken();

            curl_setopt_array($curl, array(
              CURLOPT_URL => API_URL.'/Equipments',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_POSTFIELDS =>'{
                "name": "esse ut ipsum dolor"
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht',
                'Authorization: Bearer '.$token
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            if((is_null($response))){
                echo response("0","Error in Get Equipments API",$response);
            }else{
                echo response("1","Get Equipments Successfully",$response);
            }
        break;
        case ('addEquipement'):
            $name = $request->name;
            $curl = curl_init(); 
            $token = getToken();

            curl_setopt_array($curl, array(
              CURLOPT_URL => API_URL.'/Equipments',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
              "name": "'.$name.'",
              "price": {
                "value": -17176818.039775595,
                "calculationBasisId": -12767574,
                "vat": 79332639
              },
              "bringWith": false,
              "rentable": false
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'XApiKey: XR4pHmPJ9PVnf9z2MoJnLLY5gGI2Tlqht',
                'Authorization: Bearer '.$token
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            if((is_null($response))){
                echo response("0","Error in Add Equipments API",$response);
            }else{
                echo response("1","Add Equipments Successfully",$response);
            }
        break;
        default:
        break;
    }   
