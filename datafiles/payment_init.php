<?php  
    include('../db/config.php');
    include('../db/define.php');
    $dbobjx = new Database;
    session_start();
    //======================== Include the Stripe PHP library ========================
    require_once '../vendor/stripe/stripe-php/init.php'; 
    $id = $_SESSION["userid"];
    $query = "SELECT u.package,u.type,u.charge_amount FROM users as u WHERE id = '$id' AND is_deleted='N'";
    $dbobjx->query($query);
    $result = $dbobjx->single();
    $itemName = "Demo Product";
    $itemNumber = "PN12345";
    $itemPrice = $result->charge_amount; 
    $currency = "USD";
    //======================== Set API key ========================
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
    //======================== Retrieve JSON from POST body ========================
    $jsonStr = file_get_contents('php://input'); 
    $jsonObj = json_decode($jsonStr);
    switch ($jsonObj->request_type) {
        case 'create_payment_intent':
            //======================== Define item price and convert to cents ========================
            $itemPriceCents = round($itemPrice*100); 
            //======================== Set content type to JSON ========================
            header('Content-Type: application/json'); 
            try { 
                //======================== Create PaymentIntent with amount and currency ========================
                $paymentIntent = \Stripe\PaymentIntent::create([ 
                    'amount' => $itemPriceCents, 
                    'currency' => $currency, 
                    'description' => $itemName, 
                    'payment_method_types' => [ 
                        'card' 
                    ] 
                ]);
                $output = [ 
                    'id' => $paymentIntent->id, 
                    'clientSecret' => $paymentIntent->client_secret 
                ];
                echo json_encode($output); 
            } catch (Error $e) { 
                http_response_code(500); 
                echo json_encode(['error' => $e->getMessage()]); 
            }
        break;

        case 'create_customer':
            $payment_intent_id = !empty($jsonObj->payment_intent_id)?$jsonObj->payment_intent_id:''; 
            $name = !empty($jsonObj->name)?$jsonObj->name:''; 
            $email = !empty($jsonObj->email)?$jsonObj->email:''; 
            //======================== Add customer to stripe ========================
            try {   
                $customer = \Stripe\Customer::create(array(  
                    'name' => $name,  
                    'email' => $email 
                ));  
            }catch(Exception $e) {   
                $api_error = $e->getMessage();   
            } 
            if(empty($api_error) && $customer){ 
                try { 
                    $paymentIntent = \Stripe\PaymentIntent::update($payment_intent_id, [ 
                        'customer' => $customer->id 
                    ]); 
                } catch (Exception $e) {
                } 
                $output = [ 
                    'id' => $payment_intent_id, 
                    'customer_id' => $customer->id 
                ]; 
                echo json_encode($output); 
            }else{ 
                http_response_code(500); 
                echo json_encode(['error' => $api_error]); 
            } 
        break;

        case 'payment_insert':
            $payment_intent = !empty($jsonObj->payment_intent)?$jsonObj->payment_intent:''; 
            $customer_id = !empty($jsonObj->customer_id)?$jsonObj->customer_id:''; 
            //======================== Retrieve customer info //========================
            try {   
                $customer = \Stripe\Customer::retrieve($customer_id);  
            }catch(Exception $e) {   
                $api_error = $e->getMessage();   
                echo "<pre>";print_r($api_error);die;
            } 
             
            //======================== Check whether the charge was successful //========================
            if(!empty($payment_intent) && $payment_intent->status == 'succeeded'){ 
                //======================== Transaction details  //========================
                $transactionID = $payment_intent->id; 
                $paidAmount = $payment_intent->amount; 
                $paidAmount = ($paidAmount/100); 
                $paidCurrency = $payment_intent->currency; 
                $payment_status = $payment_intent->status;                  
                $name = $email = ''; 
                if(!empty($customer)){ 
                    $name = !empty($customer->name)?$customer->name:''; 
                    $email = !empty($customer->email)?$customer->email:''; 
                }  
                //======================== Check if any transaction data is exists already with the same TXN ID ========================
                $db_txn_id = $transactionID;
                $user_id = $_SESSION['userid'];
                $query = "SELECT id FROM transactions WHERE txn_id = '$db_txn_id'";
                $dbobjx->query($query);
                $prevRow = $dbobjx->single();
                $query = "UPDATE users SET package = 'PAID',transaction_date = NOW() WHERE id = '$user_id'";
                $dbobjx->query($query);
                $dbobjx->execute();
                $paymentId = 0;
                if (!empty($prevRow)) {
                    $paymentId = $prevRow->id;
                } else {
                    //======================== Insert transaction data into the database ========================
                    $db_customer_name = $name;
                    $db_customer_email = $email;
                    $db_item_name = $itemName;
                    $db_item_number = $itemNumber;
                    $db_item_price = $itemPrice;
                    $db_item_price_currency = $currency;
                    $db_paid_amount = $paidAmount;
                    $db_paid_amount_currency = $paidCurrency;
                    $db_txn_id = $transactionID;
                    $db_payment_status = $payment_status;
                    $query = "INSERT INTO transactions (user_id,customer_name,customer_email,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES ('$user_id','$db_customer_name', '$db_customer_email', '$db_item_name', '$db_item_number', '$db_item_price', '$db_item_price_currency', '$db_paid_amount', '$db_paid_amount_currency', '$db_txn_id', '$db_payment_status',NOW(),NOW())";
                    $dbobjx->query($query);
                    if ($dbobjx->execute($query)) {
                        $paymentId = $dbobjx->lastInsertId();
                    }
                }
                $output = [
                    'payment_id' => base64_encode($paymentId),
                ];
                echo json_encode($output);
            }else{ 
                http_response_code(500); 
                echo json_encode(['error' => 'Transaction has been failed!']); 
            }
        break;
        
        default:
        # code...
        break;
    }
?>