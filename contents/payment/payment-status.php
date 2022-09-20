<?php
    $title = 'Payment Status';
    include( '../includes/header.php' );
    require_once '../../vendor/stripe/stripe-php/init.php'; 
    include("../../classes/outlendars.php");
    $outlendars = new Outlendars;
    $data = $outlendars->paymentInfo();
    // Include the Stripe PHP library 
    $payment_id = $statusMsg = '';
    $status = 'error'; 
    // Check whether the payment ID is not empty 
    if(!empty($_GET['pid'])){ 
        $payment_id  = base64_decode($_GET['pid']); 
        // Fetch transaction info from the database 
        $db_id = $payment_id; 
        $result = $outlendars->singleTransaction($db_id)->payload;
        if($result){ 
            // Transaction details 
            $transData = $result; 
            $transactionID = $transData->txn_id; 
            $paidAmount = $transData->paid_amount; 
            $paidCurrency = $transData->paid_amount_currency; 
            $payment_status = $transData->payment_status; 
            $customerName = $transData->customer_name; 
            $customerEmail = $transData->customer_email; 
            $status = 'success'; 
            $statusMsg = 'Your Payment has been Successful!'; 
        }else{ 
            $statusMsg = "Transaction has been failed!"; 
        } 
    }else{ 
        header("Location: /payment"); 
    } 
?>
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Payment Done.</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/home" class="text-outlendars">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/payment" class="text-outlendars">Payment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
        <div class="container">
            <div class="row">
                <?php if(!empty($payment_id)){ ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-right">Payment Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="formWrapper">
                            <div class="p-3 py-5">
                                <div class="row">
                                    <h3 class="text-left mb-2">Payment Information</h3>
                                    <div class="col-md-6">
                                        <label>Reference Number</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $payment_id; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Transaction ID</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $transactionID; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Paid Amount</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $paidAmount.' '.$paidCurrency; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Payment Status</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $payment_status; ?>" readonly>
                                        </div>
                                    </div>
                                    <h3 class="text-left mb-2">Customer Information</h3>
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $customerName; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $customerEmail; ?>" readonly>
                                        </div>
                                    </div>
                                    <h3 class="text-left mb-2">Product Information</h3>
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $data['itemName']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Price</label>
                                        <div class="input-group form-group">
                                            <input class="form-control" value="<?= $data['itemPrice'].' '.$data['currency']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/payment" class="btn btn-outlendars">Back To Payment</a>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title text-right error">Your Payment been failed!</h1>
                    </div>
                    <div class="card-body">
                        <div class="p-3 py-5">
                            <p class="error"><?php echo $statusMsg; ?></p>
                        </div>
                    </div>
                </div>               
                <?php } ?>
            </div>
        </div>
    </div>
<?php  
    include( '../includes/footer.php' );
?>