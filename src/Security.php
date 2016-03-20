<?php

class Security
{
    public static function SanitizeString($var)
    {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    public static function IsValid($var)
    {
        if(strlen(trim($var)) > 1)
        {
            return $var;
        }
        return false;
    }
}