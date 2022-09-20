		<footer class="page-footer font-small mt-1 fixed-bottom" style="background-color: #F6F6F6 !important;bottom: 0 !important;">
			<!-- Copyright -->
			<div class="footer-copyright text-center py-3">© <?= date('Y'); ?> Copyright | All Rights Reserved
			</div>
			<!-- Copyright -->
		</footer>
	</div>
</div>
<script src="<?= BASE_URL ?>/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/validation.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?= BASE_URL ?>/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="<?= BASE_URL ?>/assets/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?= BASE_URL ?>/assets/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?= BASE_URL ?>/assets/js/custom.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/toastr/toastr.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?= BASE_URL ?>/assets/libs/sweetalert/js/sweetalert.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/custom-datatables.js"></script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/js/bootstrap-select.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app/langswitcher.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app/customize.js"></script>
<script type="text/javascript">
$('#basic2').selectpicker({
	liveSearch: false,
	maxOptions: 1
});
</script>
<script>
$(document).ready(function() {
  let userCheck = {
    id:'<?=$_SESSION['userid']?>',
    requestType: 'checkUserDB'
  }
  $.post('datafiles/user.php', userCheck, function(result) {
    let getValues = JSON.parse(result);
    if(getValues.status == 0) {
      window.location.href = '/login';
    }
  });
});
</script>

</body>
</html>