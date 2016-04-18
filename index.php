<?php

use Agata\Services\Application;

require __DIR__ . '/vendor/autoload.php';

$start = new Application();
//$start->start();

function makeUrl($dealerWeb)
{
    if(strpos($dealerWeb, 'http://') === 0 || strpos($dealerWeb, 'https://') === 0)
    {
        $url = $dealerWeb;
    } else {
        $url = 'http://' . $dealerWeb;
    }
    return $url;
}

var_dump(makeUrl('http://www.wegd.pl'));
var_dump(makeUrl('www.wegd.pl'));
var_dump(makeUrl('http://www.wegdhttp.pl'));
var_dump(makeUrl('www.wegdhttp.pl'));
  