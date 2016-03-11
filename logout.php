<?php

require_once("src/connections.php");

unset($_SESSION['userId']);

header("Location: login.php");