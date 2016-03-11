<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}