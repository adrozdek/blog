<?php

require_once("src/connections.php");

unset($_SESSION['userId']);
$url = Param::url(false, ['action' => 'login']);
header("Location: $url");