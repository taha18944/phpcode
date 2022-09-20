<?php include "../../db/define.php";?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://codepen.io/skjha5993/pen/bXqWpR.css">
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<style>
@import url('https://fonts.googleapis.com/css?family=Numans');

html,body{
/* background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg'); */
background-size: cover;
background-color: #f3f3f3;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;
}

.container{
height: 100%;
align-content: center;
}

.card{
height: auto;
margin-top: auto;
margin-bottom: auto;
background-color: #fff !important;
width: 400px;
}

.card-header {
	text-align: center;
}

.card-header img{
	object-fit: contain;
    width: auto;
    height: 50px;
    margin-bottom: 20px;
}

.card-body{
	background-color: #fff;
	padding: 1.25rem 2.25rem;
}

.register-button{
	padding: 0 0 0 0;
}

.login_btn{
color: #fff;
background-color: #488A4C;
width: 100px;
border: none;
}

.login_btn:hover{
color: black;
background-color: #488A4C;
border: none;
}

.login_btn:focus{
	box-shadow: none;
}

.custom-input:focus{
	border-color: #488A4C;
	box-shadow: none;
}

.input-group-prepend span{
width: 50px;
background-color: #488A4C;
color: #fff;
border:0 !important;
}

.links{
color: #000;
}

.links a{
margin-left: 4px;
color: #488A4C;
}

.links a:hover{
	text-decoration: none;
	font-weight: bold;
color: #488A4C;
}

</style>