<?php

class Security
{
    static public function SanitizeString($var)
    {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    static public function IsValid($var)
    {
        if(strlen(trim($var)) > 1)
        {
            return $var;
        }
        return false;
    }
}