<?php

namespace Agata\Services;

class Param
{
    public static function getParam($name, $default = false)
    {
        return (isset($_REQUEST[$name])) ? $_REQUEST[$name] : $default;
    }

    public static function sanitize($value)
    {
        return strip_tags(mysql_real_escape_string($value));
    }

    public static function url($keep, $params = [])
    {
        $url = $_GET;
        //var_dump($_GET);
        //$base = "index.php";
        if ($keep === false) {
            $url = array();
        }
        //var_dump($url);
        foreach ($params as $name => $value) {
            $url[$name] = $value;
        }
        $res = array();
        foreach ($url as $name => $value) {
            $res[] = $name . "=" . $value;
        }
        //var_dump($res);
        return  '?' . implode("&", $res);
    }
}