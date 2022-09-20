<?php
  $title = "Payment";
  include '../includes/header.php';
  include("../../classes/outlendars.php");
  $outlendars = new Outlendars;
  $result = $outlendars->getCurrentUser()->payload;
  $payment = $outlendars->paymentInfo();
  $transactionResult = $outlendars->transactions()->payload;
?>
<?php if ($result->package != 'PAID') {?>
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h2 class="page-title">Payment Form</h2>
        <div class="ms-auto text-end">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/home" class="text-outlendars">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Payment
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body custom-card-body">
    <div id="dataTable_wrapper" class="mb-lg-5">
      <div class="checkout-card">
        <div class="formWrapper">
          <form id="paymentFrm" class="hidden p-3">
            
            <div class="row mt-4">
              <h4 class="checkout-form_title">Personal Information</h4>
              <!-- Display status message -->
              <div id="paymentResponse" class="hidden"></div>
              <!-- <form > -->
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input id="name" name="name" type="text" class="form-control rounded cutom_field" placeholder="Full Name" value="<?= ucfirst($result->username) ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input id="email" name="email" type="email" class="form-control rounded cutom_field" placeholder="@email" value="<?= $result->email ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 payment_card_info">
                <div class="row">
                  <div class="col-md-8 order_list_name">
                    <ul>
                      <li>Payment Schedule</li>
                      <li>Sub Total</li>
                      <li>Total</li>
                      <li>Tax</li>
                    </ul>
                  </div>
                  <div class="col-md-4 order_list_name">
                    <ul>
                      <li><?php echo $result->type ?></li>
                      <li><?php echo $payment['itemPrice'] ?></li>
                      <li><?php echo $payment['taxes'] ?></li>
                      <li><?php echo $payment['taxes'] ?></li>
                    </ul>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-8 order_list_name">
                    <h5>Total</h5>
                  </div>
                  <div class="col-md-4 total_amounts">
                    <?php echo '$' . $payment['itemPrice'] . ' ' . $payment['currency'] ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <h4 class="checkout-form_title">Payment Details</h4>
              <div id="paymentElement">
                <!--Stripe.js injects the Payment Element-->
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <!-- Form submit button -->
                <button id="submitBtn" class="btn btn-lg btn-block check_out_btn shadow-sm-lg p-3  cutom_field mb-4 rounded">
                <span id="buttonText" class="btn btn-outlendars float-left">Pay Now</span>
                </button>
                <!-- Display processing notification -->
                <div id="frmProcess" class="hidden">
                  <div class="spinner hidden" id="spinner"></div>
                  <span class="ring"></span> Processing...
                </div>
                <!-- <button type="button" class="">Purchase</button> -->
              </div>
            </div>
            <!-- Display re-initiate button -->
            <div id="payReinit" class="hidden">
              <button class="btn btn-primary btn-outlendars" onClick="window.location.href=window.location.href.split('?')[0]"><i class="rload"></i>Re-initiate Payment</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script src="assets/js/app/checkout.js" STRIPE_PUBLISHABLE_KEY="<?php echo STRIPE_PUBLISHABLE_KEY; ?>" defer></script>
    <?php } else {?>
    <div class="page-wrapper">
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-md-6">
            <h2 class="page-title">Payment</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="card">
          <div class="card-body custom-card-body">
            <table id="dataTable" class="table table-striped">
              <thead class="thead-custom">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Item Name</th>
                  <th>Item Price</th>
                  <th>Item Price Currency</th>
                  <th>Paid Amount</th>
                  <th>Paid Amount Currency</th>
                  <th>Payment Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($transactionResult as $row) { ?>
                  <tr>
                    <td><?= ucfirst($row->customer_name) ?></td>
                    <td><?= $row->customer_email ?></td>
                    <td><?= $row->item_name ?></td>
                    <td><?= $row->item_price ?></td>
                    <td><?= $row->item_price_currency ?></td>
                    <td><?= $row->paid_amount ?></td>
                    <td><?= $row->paid_amount_currency ?></td>
                    <td><?= $row->payment_status ?></td>
                    <td>
                      <a href="/payment-detail?id=<?= $row->id ?>"><i class="fas fa-search search-icon"></i></a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php }?>
<?php include '../includes/footer.php';?>
<script> $("#dataTable").DataTable(); </script>