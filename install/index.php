<?php require_once 'init.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="theme-color" content="#fff">
    <link as="style" media="all" rel="stylesheet" href="../public/assets/css/theme.css" type="text/css" crossorigin="anonymous" />
    <title>Installation</title> 
</head>

<body class="d-flex align-items-center min-vh-100 bg-white">
    <div class="container py-lg-6">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?php 
                if(empty($_GET['step'])) { 
                    require_once 'common/welcome.fragment.php';
                } elseif(isset($_GET['step']) AND $_GET['step'] == '2') {
                    require_once 'common/requirements.fragment.php';
                } elseif(isset($_GET['step']) AND $_GET['step'] == '3') {
                    require_once 'common/controls.fragment.php';
                } elseif(isset($_GET['step']) AND $_GET['step'] == 'success') {
                    require_once 'common/success.fragment.php'; 
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>