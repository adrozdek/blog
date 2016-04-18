<?php

namespace Agata\Core;

class Controller
{
    protected function checkIfUserSessionExist()
    {
        if (isset($_SESSION['userId'])) {
            return true;
        } 
        return false;
    }

    public function sanitizeString($var)
    {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    public function isValid($var)
    {
        if (strlen(trim($var)) > 1) {
            return $var;
        }
        return false;
    }
}