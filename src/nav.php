<html>
<head>

    <link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='styles/css/mystyles.css'>

</head>

<?php

if (isset($_SESSION['userId'])) {
    require_once './Template/navUser.php';
} else {
    require_once './Template/navStranger.php';
}

?>