<?php include ("../../db/define.php");?>
<!DOCTYPE html>
<html>
	<head>
		<title><?= (isset($title)&&!empty($title))? $title.' | Outlendars' : 'Outlendars' ; ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
		<link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/assets/favicon/favicon.jpg">
  		<link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/assets/favicon/favicon.jpg">
		<link href="<?= BASE_URL ?>/assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/libs/toastr/build/toastr.min.css">
		<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/custom_style.css">
	</head>