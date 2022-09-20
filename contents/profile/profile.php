<?php
    $title = 'Profile'; 
    include( '../includes/header.php' );
    require('../../db/config.php');
    $id = $_SESSION['userid'];
    $dbobjx =  new Database;
    $query = "SELECT * FROM users WHERE id = '$id'";
    $dbobjx->query($query);
    $result = $dbobjx->single();
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
                        <div class="col-md-3 border-right">
                            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                <img class="rounded-circle mt-5" width="150px" src="<?= BASE_URL ?>/assets/images/user-2.png">
                                <span class="font-weight-bold"><?= ucfirst($result->username) ?></span>
                                <span class="text-black-50"><?= $result->email ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="formWrapper">
                                <form class="needs-validation" method="post">
                                    <div class="p-3 py-5">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="text-right">Profile Settings</h4>
                                        </div>
                                        <div class="input-group form-group">
                                            <input type="text" name="username" id="username" class="form-control" required="" placeholder="Full Name" value="<?= ucfirst($result->username) ?>">
                                        </div>
                                        <div class="input-group form-group">
                                            <input type="text" name="phone" id="phone" class="form-control digits" placeholder="enter phone number" required="" value="<?= $result->phone ?>">
                                        </div>
                                        <div class="input-group form-group">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="enter email id" value="<?= $result->email ?>" readonly="">
                                        </div>
                                        <div class="mt-5">
                                            <button class="btn btn-outlendars" type="button" id="submit" name="submit" onclick="updateProfile();">Update Profile</button>
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