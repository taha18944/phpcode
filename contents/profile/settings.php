<?php
    $title = 'Settings';
    include( '../includes/header.php' );
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
                            <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card w-75">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="formWrapper">
                                <form class="needs-validation" novalidate method="post">
                                    <div class="p-3 py-5">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="text-right"><?= $title ?></h4>
                                        </div>
                                            <div class="input-group form-group">
                                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password">
                                            </div>                       
                                            <div class="input-group form-group pt-1">
                                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
                                            </div>
                                            <div class="input-group form-group">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                            </div>
                                        <div class="mt-5">
                                            <button class="btn btn-outlendars" type="button" id="submit" name="submit" onclick="changePassword();">Change Password</button>
                                            <a href="/home" class="btn btn-outline-outlendars">Cancel</a>

                                        </div>
                                    </div>
                                </form>
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