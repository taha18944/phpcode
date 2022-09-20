<?php
    $title = 'Payment Detials'; 
    include( '../includes/header.php' );
    require('../../classes/outlendars.php');
    $recordId = $_GET['id'];
    $outlendars = new Outlendars;
    $result = $outlendars->getCurrentUser()->payload;
    $singleResult = $outlendars->singleTransaction($recordId)->payload;
?>
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title"><?= $title ?></h4>
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
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-left">Payment Detail</h4>
                </div>
                <div class="card-body">
                    <div class="formWrapper">
                        <div class="p-3 py-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="username" id="username" class="form-control" value="<?= ucfirst($result->username) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Phone</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="phone" id="phone" class="form-control digits" value="<?= $result->phone ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Email</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $result->email ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Item Name</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->item_name ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Item Number</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->item_number ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Item Price</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->item_price ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Item Price Currency</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->item_price_currency ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Paid Amount</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->paid_amount ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Paid Amount Currency</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->paid_amount_currency ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>TXN Id</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->txn_id ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Payment Status</label>
                                    <div class="input-group form-group">
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $singleResult->payment_status ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php include( '../includes/footer.php' ); ?>
<script src="<?= BASE_URL ?>/assets/js/app/settings.js"></script>
</body>
</html>