<?php
  $title = 'Add Offer';
  include( '../includes/header.php' );
  include( '../../classes/outlendars.php' );
  $outlendars = new Outlendars;
  $user_role = $outlendars->getCurrentUser()->payload->role_id;
  $dropdown_set="false";
  $dropdowns_array=[];
  $activity_array=[];
  $place_array=[];
  $payment_location_array=[];
  $day_week_array=[];
  $calculationBasis_array=[];
  if(isset($_SESSION['dropdowns'])){

    $dropdown_set = "true";
    $dropdowns_array=$_SESSION['dropdowns'];
    $activity_array =json_decode($dropdowns_array['activities'],true);
    $place_array=json_decode($dropdowns_array['places'],true);
    $payment_location_array=json_decode($dropdowns_array['payment_locations'],true);
    $day_week_array=json_decode($dropdowns_array['dayofweek'],true);
    $calculationBasis_array=json_decode($dropdowns_array['CalculationBasis'],true);

  }
?>
<style>
  .table>tbody {
    /* vertical-align: inherit; */
    height: 200px !important;
    overflow-y: scroll;
    width: 100%;
    display: table-caption;
    /* overflow: scroll; */
}
tbody, td, tfoot, th, thead, tr {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
    width: inherit;
    display: inline-flex;
}
</style>
<div class="page-wrapper">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body wizard-content">
      <input id="dropdown_set" name="dropdown_set" type="text" class="form-control" value="<?= $dropdown_set ?>" hidden/>
        <h4 class="form_heading_title">New Offer</h4>
        <h6 class="card-subtitle"></h6>
        <form id="example-form" class="needs-validation" action="../../datafiles/offers.php" class="mt-5" method="post" enctype="multipart/form-data">
          <div>
            <hr>
            <h3>Detail</h3>
            <section>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userName">Name</label>
                    <input id="userName" name="userName" type="text" class="form-control"/>
                    <input type="hidden" name="requestType" value="add_offer">
                  </div>
                  <div class="form-group">
                    <label for="activity">Activity</label>
                    <select class="form-select" id="activity" name="activity">
                      <option selected disabled>Activity</option>
                      <?php if($dropdown_set="true"){
                              foreach($activity_array as $activity){?>
                              <option value="<?= $activity['id'] ?>"><?= $activity['name'] ?></option>
                              
                          <?php }} ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="place">Place</label>
                    <select class="form-select" id="place" name="place">
                      <option selected disabled>Select Place</option>
                      <?php if($dropdown_set="true"){
                              foreach($place_array as $place){?>
                              <option value="<?= $place['id'] ?>"><?= $place['name'] ?></option>
                              
                          <?php }} ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label></lable>
                      <input type="image" id="output" onclick="$('#my_file').click();return false;" src="<?= BASE_URL ?>/assets/images/image_upload.png" width="270" height="150" />
                      <input type="file" id="my_file" name ="my_file" onchange="loadFile(event)" accept="image/*" style="display: none;" />
                      <input type="hidden" id="image_path">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-12">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="6" ></textarea>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="userName">Terms and Conditions (URL)</label>
                    <input id="termsCondition" name="termsCondition" type="text" class="form-control"/>
                    
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-3">
                    <label for="validFrom">Valid From</label>
                    <input
                    id="validFrom"
                    name="validFrom"
                    type="date"
                    class=" form-control"
                    />
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="validTo">Valid To</label>
                    <input
                    id="validTo"
                    name="validTo"
                    type="date"
                    class=" form-control"
                    />
                  </div>
                </div>
              </section>
              <h3>Payment</h3>
              <section>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label for="price_without_tax">Name</label>
                        <input id="price_name" name="price_name" type="number"  placeholder="Price Name" class=" form-control"/>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="price_without_tax">Price without tax</label>
                        <input id="price_without_tax" name="price_without_tax" type="number"  placeholder="€" class=" form-control"/>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="vat">VAT</label>
                        <input id="vat" name="vat" type="number" class=" form-control" placeholder="%" />
                      </div>
                    </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                    <label for="calculated_by">Calculated By</label>
                    <select class="form-select" id="calculated_by" name="calculated_by">
                      <option selected disabled>Select Calculation Base</option>
                      <?php if($dropdown_set="true"){
                              foreach($calculationBasis_array as $calculation){?>
                              <option value="<?= $calculation['id'] ?>"><?= $calculation['name'] ?></option>
                              
                          <?php }} ?>
                    </select>
                  </div>
                  <div class="col-md-3 form-group">
                        <label for="vat">Duration for </label>
                        <input id="durNo" name="durNo" type="number" class=" form-control"/>
                  </div>
                  <div class="col-md-3 form-group">
                        <label for="vat">1 activity</label>
                        <select class="form-select" id="durHour" name="durHour">
                          <option selected disabled>Hours</option>
                        </select>
                  </div>
                </div>
                  </div>
                  <div class="col-md-6 form_board">
                    <div class="row">
                      <div class="col-md-3 form_board_head">Preview</div>
                      <div class="col-md-3 price_board">
                        <ul style="list-style: none;">
                          <li class="price_li_head">01/01</li>
                          <li>2 attendees</li>
                          <li>3 time</li>
                          <li>1 hour</li>
                        </ul>
                      </div>
                      <div class="col-md-3 price_board">
                        <ul style="list-style: none;">
                          <li class="price_li_head">01/01</li>
                          <li>2 attendees</li>
                          <li>1 time</li>
                          <li>3 hour</li>
                        </ul>
                      </div>
                      <div class="col-md-3 price_board">
                        <ul style="list-style: none;">
                          <li class="price_li_head">01/01</li>
                          <li>1 attendees</li>
                          <li>3 time</li>
                          <li>2 hour</li>
                        </ul>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-12 below_form_board ">
                        <div class="row">
                          <div class="col-md-3">Net Revenue</div>
                          <div class="col-md-3">1,00 €</div>
                          <div class="col-md-3">2,00 €</div>
                          <div class="col-md-2">3,00 €</div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">Tax</div>
                          <div class="col-md-3">1,00 €</div>
                          <div class="col-md-3">2,00 €</div>
                          <div class="col-md-2">3,00 €</div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">Gross Sale</div>
                          <div class="col-md-3">1,00 €</div>
                          <div class="col-md-3">2,00 €</div>
                          <div class="col-md-2">3,00 €</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="payment_location">Payment Location</label>
                    <select class="form-select" id="payment_location" name="payment_location">
                      <option selected disabled>Select Payment Location</option>
                      <?php if($dropdown_set="true"){
                              foreach($payment_location_array as $paymentLocation){?>
                              <option value="<?= $paymentLocation['id'] ?>"><?= $paymentLocation['name'] ?></option>
                              
                          <?php }} ?>
                    </select>
                  </div>
                  <div class="col-md-12 hide_default">
                    <label>Payment way</label>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="cashCheck" name="cashCheck">
                      <label class="form-check-label" for="cashCheck">Cash</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="cashBank">
                      <label class="form-check-label" for="cashBank">Bank Card</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="cashcredicard" value="Credit Card">
                      <label class="form-check-label" for="cashcredicard">Credit Card</label>
                    </div>
                  </div>
                  
                </div>
               
              </section>
              <!-- <h3>Payment</h3>
              <section>
                <div class="row">
                  <div class="form-group col-lg-4">
                    <label for="payment_location">Payment Location</label>
                    <select class="form-select" id="payment_location" name="payment_location">
                      <option selected>Select Payment Location</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-8">
                    <label>Cancellation time</label>
                    <input id="web_url" name="web_url" type="text" class="form-control" placeholder="Hours" />
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <label>Payment way</label>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="cashCheck" name="cashCheck" value="Cash" checked>
                      <label class="form-check-label" for="cashCheck">Cash</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="cashBank" value="Bank Card" checked>
                      <label class="form-check-label" for="cashBank">Bank Card</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="cashcredicard" value="Credit Card" checked>
                      <label class="form-check-label" for="cashcredicard">Credit Card</label>
                    </div>
                  </div>
                </div>
              </section> -->
              <h3>Reservation</h3>
              <section>
                <h5>How many participants are necessary for the offer to be used?</h5>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="min_att">Min. Attendees</label>
                        <select class="form-select" id="min_att" name="min_att">
                          <option selected>1</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="max_att">Max. Attendees</label>
                        <select class="form-select" id="max_att" name="max_att">
                          <option selected>4</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12">
                        <div class="form-check form-group form-switch">
                          <input class="form-check-input" type="checkbox" id="reservationReqCheck" name="reservationReqCheck" value="Reservation Request" checked>
                          <label class="form-check-label" for="reservationReqCheck">Reservation Request is mandatory</label>
                        </div>
                      </div>
                      <div class="form-group col-lg-12 show_check_res">
                        <label>Cancellation time</label>
                        <input id="web_url" name="web_url" type="text" class="form-control" placeholder="Hours" />
                      </div>
                    </div>
                  </div>
                 
                  <div class="col-md-6 form_board show_check_res">
                    <div class="row">
                      <div class="form_heading">
                        <h5>Your timeslots</h5>
                      </div>
                      <div class="reservation_form_list">
                        <div class="row timeList">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-5 show_check_res">
                  <h4 for="can_G2G">Free Time slots</h4>
                  <h5>Add timeswhen no reservation request is necessary</h5>
                  <div class="form-group col-lg-6">
                    <label for="day">Day</label>
                    <select class="form-select" id="day" name="day">
                    <?php if($dropdown_set="true"){
                              foreach($day_week_array as $day){?>
                              <option value="<?= $day['id'] ?>"><?= $day['name'] ?></option>
                              
                          <?php }} ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <div class="row">
                      <div class="col-lg-6">
                      <label for="validfromLast">From</label>
                        <input class="form-control" type="time" id="fromTime" name="fromTime[]">
                      </div>
                      <div class="col-lg-6">
                        <label for="validfromLast">To</label>
                        <input class="form-control" type="time" id="toTime" name="toTime[]">
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="mmroooolingmm" value="<?= ($user_role == '2') ? '14' : '1' ?>">
                <div class="row">
                  <div class="col-md-12 text-end reservation_add_btn">
                    <a href="#" class="btn btn-lg active" role="button" aria-pressed="true" id="add_time">Add time Slot</a>
                  </div>
                </div>
                </div>
              </section>
              <h3>Equipment</h3>
                <section>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="equipments">Add New Equipment</label>
                        <input id="equipments" name="equipments" type="text" class=" form-control" placeholder="Select Equipment(for example:sport shoes)" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <a href="javascript:void(0);" class="text-outlendars btn btn-lg active reservation_add_btn add_equi" role="button" id="add_equipments" aria-pressed="true">Add Equipment</a>
                    </div>
                    <div class="col-md-3 form-group">
                      <label for="price_without_tax2">Price without tax</label>
                      <input id="price_without_tax2" name="price_without_tax2" type="number"  placeholder="€ 0" class="form-control"/>
                    </div>
                    <div class="col-md-3 form-group">
                      <label for="vat2">VAT</label>
                      <input id="vat2" name="vat2" type="number" class=" form-control" placeholder="% 19" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="calculated_by2">Calculated By</label>
                      <select class="form-select" id="calculated_by2" name="calculated_by2">
                        <option selected disbaled>Select Calculation Base</option>
                        <?php if($dropdown_set="true"){
                              foreach($calculationBasis_array as $calculation){?>
                              <option value="<?= $calculation['id'] ?>"><?= $calculation['name'] ?></option>
                              
                          <?php }} ?>
                      </select>
                    </div>
                  </div>
                  <hr>
                  <div class="">
                    <table class="table table-striped" id="equip">
                      <thead class="thead-custom">
                        <tr>
                          <th>ID</th>
                          <th>SELECT EQUIPMENT</th>
                          <th>Should the guest bring</th>
                          <th>Can be borrowed</th>
                        </tr>
                      </thead>
                      <tbody id="equipmentList">
                      </tbody>
                    </table>
                  </div>
                </section>
              </div>
              <button class="hidden d-none" id="submitBtn" type="submit"></button>
            </form>
          </div>
        </div>
      </div>
      <?php include( '../includes/footer.php' );?>
      <script type="text/javascript">
        $(document).on('click','a[href*=\\#finish]',function () {
          $('#submitBtn').click();
        })
      </script>
      <script src="<?= BASE_URL ?>/assets/js/app/add_offer.js"></script>