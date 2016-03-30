<?php

require_once 'Param.php';

class Application
{
    public function __construct()
    {
        //whatever - init all u need. nothing ? :P
    }

    public static function start() {
        $action = Param::getParam('action', false);
        //var_dump($action);

        switch($action) {
            case "login":
                require_once ('./login.php');
                break;
            case "logout":
                require_once ('./logout.php');
                break;
            case "bloggers":
                require_once ('./bloggers.php');
                break;
            case "newPost":
                require_once ('./newPost.php');
                break;
            case "register":
                require_once ('./register.php');
                break;
            case "editComment":
                require_once ('./editComment.php');
                break;
            case "editPost":
                require_once './editPost.php';
                break;
            case "showPost":
                require_once './showPost.php';
                break;
            case "search":
                require_once ('./search.php');
                break;
            case "remove":
                require_once ('./remove.php');
                break;
            case "profile":
                require_once ('./profile.php');
                break;
            default:
                require_once ('./default.php');
                break;
        }
    }
}