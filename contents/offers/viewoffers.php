<?php
  $title = 'Offers';
  include( '../includes/header.php' );
?>
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title">Offers</h2>
      </div>
      <div class="col-md-6 ms-auto text-end">
        <div class="add-btn">
          <a href="<?= BASE_URL ?>/add_offer" class="btn btn-outlendars" role="button" aria-pressed="true">New</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="card">
      <div class="card-body custom-card-body">
        <table id="dataTable" class="table table-striped">
          <thead class="thead-custom">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Activity ID</th>
              <th>Min Attendees</th>
              <th>Max Attendees</th>
              <th>Valid Time</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="offers">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include( '../includes/footer.php' ); ?>
<script>
  let dataOffers = {
    requestType: 'get_offers'
  }
  $.post('datafiles/offers.php', dataOffers, function(result) {
    let getValues = JSON.parse(result);
    console.log(getValues);
    let payload = JSON.parse(getValues.payload.payload);
    $.each(payload, function(key, value) {
      $("#offers").append(
        `<tr>
          <td>${value.id}</td>
          <td>${value.name}</td>
          <td>${value.activityId}</td>
          <td>${value.minAttendees}</td>
          <td>${value.maxAttendees}</td>
          <td>${value.validFrom} TO ${value.validTo}</td>
          <td>
            <a href="javascript:void(0)" class="confirmDelete" offer_id="${value.id}"><i class="fas fa-prescription-bottle-alt bin-icon-btn"></i></a>
            <a href="/edit_offer?offer_id=${value.id}"><i class="fas fa-pencil-alt edit-icon-btn"></i></a>
            <a href=""><i class="fas fa-search search-icon"></i></a>
          </td>
        </tr>`
        );
    });
    $("#dataTable").DataTable();
  });
  // $(document).ready(function() {
  // let getofferdata = {
  //   requestType: 'get_offer'
  // }
  // $.post('datafiles/offers.php', getofferdata, function(result) {
  //   let getValues = JSON.parse(result);
  //   let payload = JSON.parse(getValues.payload.payload);
  //   $.each(payload, function(key, value) {
  //     $("#activity").append(new Option(value.name, value.id));
  //   });
  // });
  // });
</script>
</body>