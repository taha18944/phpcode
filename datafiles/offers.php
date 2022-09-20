<?php 
    session_start();
    include('index.php');
    include("../classes/outlendars.php");
    $outlendars = new Outlendars();
    $requestType = $_POST['requestType'];
    
    switch ($requestType) {
        case 'add_offer':
            $name = $_POST['userName'];
            $activity = $_POST['activity'];
            $errors= array();
            $my_file = $_FILES['my_file']['name'];
            $file_size = $_FILES['my_file']['size'];
            $file_tmp = $_FILES['my_file']['tmp_name'];
            $file_type = $_FILES['my_file']['type'];
            $final_path;
            $file_ext=strtolower(end(explode('.',$my_file)));
            $extensions= array("jpeg","jpg","png");
      
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if($file_size > 2097152) {
                $errors[]='File size must be excately 2 MB';
                exit;
            }
            
            if(empty($errors)==true) {
                move_uploaded_file($file_tmp,"images_directory/".$my_file);
                $final_path =__DIR__."\images_directory/".$my_file;
            }else{
                print_r($errors);
                die;
            }
    
            $description = $_POST['description'];
            $reservationReqCheck= (isset($_POST['reservationReqCheck']) && $_POST['reservationReqCheck']=="on") ? "true" : "false";
            $validFrom = isset($_POST['validFrom']) ? $_POST['validFrom'] : '';
            $validTo = isset($_POST['validTo']) ? $_POST['validTo'] : '';
            $days_array= isset($_POST['day_slot']) ? $_POST['day_slot'] : [];
            $from_array_array=isset($_POST['fromTime_slot']) ? $_POST['fromTime_slot'] : [];
            $to_array=isset($_POST['toTime_slot']) ? $_POST['toTime_slot'] : [];
            $time_slot_array=[];
            for($i=0;$i<count($days_array);$i++){
                $time_slot_array_new = array(
                                    "startTime" =>$from_array_array[$i],
                                    "endTime" =>$to_array[$i],
                                    "day"=>$days_array[$i]
                );
                $time_slot_array[] = $time_slot_array_new;
            }
            $time_slot_array_json=json_encode($time_slot_array,JSON_NUMERIC_CHECK);
            $price_without_tax = $_POST['price_without_tax'];
            $vat = $_POST['vat'];
            $calculated_by = $_POST['calculated_by'];
            $applies_from=array("startTime"=>"1987-12-30T07:45:34.621Z","endTime"=>"1987-12-30T07:45:34.621Z","day"=>0);
            $price_array=array("value"=>$price_without_tax,"calculationBasis"=>$calculated_by,"vat"=>$vat,"name"=>"demo price",
                                "activityDuration"=>23,"activityDurationTimeUnit"=>1,"baseAmount"=>32,"timeUnit"=>1,"attendeeAmount"=>35,"appliesTo"=>2,"appliesFrom"=>array($applies_from));
            $payment_location = $_POST['payment_location'];
            $cancelation_time = $reservationReqCheck == false ? $_POST['web_url'] : 0;
            $cashCheck= (isset($_POST['cashCheck']) && $_POST['cashCheck']=="on") ? "true" : "false";
            $cashcredicard= (isset($_POST['cashcredicard']) && $_POST['cashcredicard']=="on") ? "true" : "false";
            $cashBank= (isset($_POST['cashBank']) && $_POST['cashBank']=="on") ? "true" : "false";
            $min_att = $_POST['min_att'];
            $max_att = $_POST['max_att'];
            
            $day = isset($_POST['day']) ? $_POST['day'] : '';
            $fromTime = isset($_POST['fromTime']) ? $_POST['fromTime'] : '';
            $toTime = isset($_POST['toTime']) ? $_POST['toTime'] : '';
            $place = $_POST['place'];
            $equipIDS=json_encode($_POST['equipIDS'],JSON_NUMERIC_CHECK);

            $token=getToken();
           // die($token);
            $headers = array();
            $headers[] = 'Content-Type: multipart/form-data';
            $headers[] = 'Accept: application/json';
            $headers[] = 'XApiKey: '.XApiKey;
            $headers[] = 'Authorization: Bearer '.$token;
            $post = array(
                'activityId' => 2,
                'image'=> new CURLFILE($final_path),
            );
            // print_r($post);
            // die;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, API_URL.'/Images');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $resultImage = json_decode(curl_exec($ch),true);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $data = array(

                "name"=>$name,
                "activityId"=>$activity,
                "regionId"=>2,
                "description"=>$description,
                "validFrom"=>$validFrom,
                "validTo"=>$validTo,
                "price"=>array($price_array),
                "timseSlots"=>$time_slot_array,
                "equipmentIds"=>$equipIDS,
                "paymentLocation"=>$payment_location,
                "cancelationTime"=>$cancelation_time,
                "acceptCash"=>$cashCheck,
                "acceptDebitCard"=>$cashBank,
                "acceptCreditCard"=>$cashcredicard,
                "minAttendees"=>$min_att,
                "maxAttendees"=>$max_att,
                "reservationRequestRequired"=>$reservationReqCheck,
                "placeId"=>$place,
                "imageId"=>$resultImage['id']
            );
            // echo"<pre>";print_r(json_encode($data));die;
            $revised_header= array(
                'Content-Type: application/json',
                'Accept: application/json',
                'XApiKey: '.XApiKey,
                'Authorization: Bearer '.$token
            );
            $create_offer_response=curlFunction_revised(API_URL.'/Offers',json_encode($data),$revised_header,'POST');
            print_r($create_offer_response);
            die;
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            // CURLOPT_URL => API_URL.'/Offers',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS =>'{
            //     "name": "'.$name.'",
            //     "activityId": '.$activity.',
            //     "regionId": 2,
            //     "description": "'.$description.'",
            //     "validFrom": "'.$validFrom.'",
            //     "validTo": "'.$validTo.'",
            //     "price": {
            //         "value": '.$price_without_tax.',
            //         "calculationBasisId": '.$calculated_by.',
            //         "vat": '.$vat.',
            //         "name": "incididunt laborum",
            //         "activityDuration": -68802961,
            //         "activityDurationTimeUnit": 0,
            //         "baseAmount": 15678372,
            //         "timeUnit": 0,
            //         "attendeeAmount": -72266186,
            //         "appliesTo": 1,
            //         "validForPublicHoliday": false,
            //         "validForSchoolHoliday": true
            //     },
            //     "timeSlots":'.$time_slot_array_json.',
            //     "equipmentIds": '.$equipIDS.',
            //     "paymentLocation": '.$payment_location.',
            //     "cancelationTime": '.$cancelation_time.',
            //     "acceptCash": '.$cashCheck.',
            //     "acceptDebitCard": '.$cashBank.',
            //     "acceptCreditCard": '.$cashcredicard.',
            //     "minAttendees": '.$min_att.',
            //     "maxAttendees": '.$max_att.',
            //     "reservationRequestRequired": '.$reservationReqCheck.',
            //     "placeId": '.$place.',
            //     "imageId": '.$resultImage['id'].'
            //   }',
            //     CURLOPT_HTTPHEADER => array(
            //       'Content-Type: application/json',
            //       'Accept: application/json',
            //       'XApiKey: '.XApiKey,
            //       'Authorization: Bearer '.$token
            //     ),
            //   ));

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            print_r($response);
            die;
           
            if(($httpcode == 200)){
                echo '<script>alert("Offer Created Sucessfully")</script>';
                header("Location:/add_offer");
               
            }else{
                echo '<script>alert("Error in offer API")</script>';
                header("Location:/add_offer");
            }
        break;

        case 'edit_offer':
            // $return = $outlendars->addOffers();
            // echo response("1","Offer Created Successfully",$return); 
            $offerID=$_POST['offer_ID'];
            $name = $_POST['userName'];
            $activity = $_POST['activity'];
            $errors= array();
            $my_file = $_FILES['my_file']['name'];
            $file_size = $_FILES['my_file']['size'];
            $file_tmp = $_FILES['my_file']['tmp_name'];
            $file_type = $_FILES['my_file']['type'];
            $final_path;
            $file_ext=strtolower(end(explode('.',$my_file)));
            $extensions= array("jpeg","jpg","png");
      
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if($file_size > 2097152) {
                $errors[]='File size must be excately 2 MB';
            }
            
            if(empty($errors)==true) {
                move_uploaded_file($file_tmp,"images_directory/".$my_file);
                $final_path =__DIR__."\images_directory/".$my_file;
            }else{
                print_r($errors);
                die;
            }
            $description = $_POST['description'];
            $reservationReqCheck= (isset($_POST['reservationReqCheck']) && $_POST['reservationReqCheck']=="on") ? "true" : "false";
            $validFrom = isset($_POST['validFrom']) ? $_POST['validFrom'] : '';
            $validTo = isset($_POST['validTo']) ? $_POST['validTo'] : '';
            $days_array= isset($_POST['day_slot']) ? $_POST['day_slot'] : [];
            $from_array_array=isset($_POST['fromTime_slot']) ? $_POST['fromTime_slot'] : [];
            $to_array=isset($_POST['toTime_slot']) ? $_POST['toTime_slot'] : [];
            $time_slot_array=[];
            for($i=0;$i<count($days_array);$i++){
                $time_slot_array_new = array(
                                    "startTime" =>$from_array_array[$i],
                                    "endTime" =>$to_array[$i],
                                    "day"=>$days_array[$i]
                );
                $time_slot_array[] = $time_slot_array_new;
            }
            $time_slot_array_json=json_encode($time_slot_array,JSON_NUMERIC_CHECK);
            $price_without_tax = $_POST['price_without_tax'];
            $vat = $_POST['vat'];
            $calculated_by = $_POST['calculated_by'];
            $price_array=array("value"=>$price_without_tax,"calculationBasis"=>$calculated_by,"vat"=>$vat);
            $payment_location = $_POST['payment_location'];
            $cancelation_time = $reservationReqCheck == false ? $_POST['web_url'] : 0;
            $cashCheck= (isset($_POST['cashCheck']) && $_POST['cashCheck']=="on") ? "true" : "false";
            $cashcredicard= (isset($_POST['cashcredicard']) && $_POST['cashcredicard']=="on") ? "true" : "false";
            $cashBank= (isset($_POST['cashBank']) && $_POST['cashBank']=="on") ? "true" : "false";
            $min_att = $_POST['min_att'];
            $max_att = $_POST['max_att'];
            
            $day = isset($_POST['day']) ? $_POST['day'] : '';
            $fromTime = isset($_POST['fromTime']) ? $_POST['fromTime'] : '';
            $toTime = isset($_POST['toTime']) ? $_POST['toTime'] : '';
            $place = $_POST['place'];
            $equipIDS=json_encode($_POST['equipIDS'],JSON_NUMERIC_CHECK);

            $token=getToken();
            // die($token);
             $headers = array();
             $headers[] = 'Content-Type: multipart/form-data';
             $headers[] = 'Accept: application/json';
             $headers[] = 'XApiKey: '.XApiKey;
             $headers[] = 'Authorization: Bearer '.$token;
             $post = array(
                 'activityId' => 2,
                 'image'=> new CURLFILE($final_path),
             );
             // print_r($post);
             // die;
             $ch = curl_init();
 
             curl_setopt($ch, CURLOPT_URL, API_URL.'/Images');
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
             
             
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             
             $resultImage = json_decode(curl_exec($ch),true);
             if (curl_errno($ch)) {
                 echo 'Error:' . curl_error($ch);
             }
             curl_close($ch);

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => API_URL.'/Offers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
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
                "timeSlots":'.$time_slot_array_json.',
                "equipmentIds": '.$equipIDS.',
                "paymentLocation": '.$payment_location.',
                "cancelationTime": '.$cancelation_time.',
                "acceptCash": '.$cashCheck.',
                "acceptDebitCard": '.$cashBank.',
                "acceptCreditCard": '.$cashcredicard.',
                "minAttendees": '.$min_att.',
                "maxAttendees": '.$max_att.',
                "reservationRequestRequired": '.$reservationReqCheck.',
                "placeId": '.$place.',
                "imageId": '.$resultImage['id'].',
                "id":'.$offerID.'
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
            if(($httpcode == 200)){
                echo '<script>alert("Offer Created Sucessfully")</script>';
                header("Location:/add_offer");
               
            }else{
                echo '<script>alert("Error In Offer API")</script>';
                //header("Location:/add_offer");
            }
        break;
        case 'get_offer_byID':
            $id=$_POST['offerID'];
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
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>'{}',
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

            if($httpcode == 200){
                $_SESSION['offers_byID']=$response;
                echo response("1","Offers",$response);
                
                
            }else{
                echo response("0","Error in Offers API",$response);
            }
		break;

        case 'get_offers':
            $return = $outlendars->getOffers();
            echo response("1","Offers",$return);
        break;

        case 'offer_count':
            $return = $outlendars->offerCounter($_SESSION['package']);
            if($return == "true"){
                echo response("1","Allowed for new offer",[]);
            }else{
                echo response("0","Not Allowed for new offer",[]);
            }
        break;

        case 'get_equipment':
            $return = $outlendars->getEquipement();
            echo response("1","Equipments",$return);
        break;

        case 'add_equipment':
            $return = $outlendars->addEquipement($_POST['name']);
            echo response("1","Add Equipments",$return);
        break;

        case 'deleteOffer':
            $return = $outlendars->deleteOffer($_POST['offer_id']);
            echo response("1","Delete Offer",$return);
        break;
        case 'get_dropdowns':
            $token = getToken();
			$url = API_URL.'/CalculationBasis';
			$headers = array(
				"Content-type: application/json",
				"XApiKey: ".XApiKey,
				"Authorization: Bearer ".$token
			);
			$returnCalculationBasis = curlFunction($url,"",$headers,"",'GET');

			$url = API_URL.'/Places';
			$headers = array(
				"Content-type: application/json",
				"XApiKey: ".XApiKey,
				"Authorization: Bearer ".$token
			);
			$returnPlaces = curlFunction($url,"",$headers,"",'GET');

			$url = API_URL.'/Activities';
			$headers = array(
				"Content-type: application/json",
				"XApiKey: ".XApiKey,
				"Authorization: Bearer ".$token
			);
			$returnActivities = curlFunction($url,"",$headers,"",'GET');

			$url = API_URL.'/PaymentLocation';
			$headers = array(
				"Content-type: application/json",
				"XApiKey: ".XApiKey,
				"Authorization: Bearer ".$token
			);
			$returnPaymentLocation = curlFunction($url,"",$headers,"",'GET');

			$url = API_URL.'/DayOfWeek';
			$headers = array(
				"Content-type: application/json",
				"XApiKey: ".XApiKey,
				"Authorization: Bearer ".$token
			);
			$returnDayOfWeek = curlFunction($url,"",$headers,"",'GET');
			$returnedDropDown = [
				"CalculationBasis"=>(!is_null($returnCalculationBasis) ? $returnCalculationBasis : []),
				"places" =>(!is_null($returnPlaces) ? $returnPlaces : []),
				"activities"=>(!is_null($returnActivities) ? $returnActivities : []),
				"payment_locations"=>(!is_null($returnPaymentLocation) ? $returnPaymentLocation : []),
				"dayofweek"=>(!is_null($returnDayOfWeek) ? $returnDayOfWeek : []),
			];
            $_SESSION['dropdowns']=$returnedDropDown;
			echo response("1","Drop Downs",$returnedDropDown);
        break;
        
    default:
    # code...
    break;
    }
?>