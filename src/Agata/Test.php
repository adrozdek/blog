<?php
/**
 * Created by PhpStorm.
 * User: adrozdek
 * Date: 14.04.16
 * Time: 13:01
 */

namespace src\Agata;


use TreeRoute\Router;

class Test
{
    public function test() {
        echo 'Agata';
    }

    public function run() {
        $router = new Router();
        $router->addRoute(['GET'],'/',function() {echo "hello";});
        
    }
}