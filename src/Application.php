<?php

namespace klas;

require_once 'Param.php';
//require_once './Controllers/PostController.php';

use \controller\PostController;
//use \klas\Param;

class Application
{
    public static function start() {
        $param = new Param();
        $action = $param::getParam('action', false);
        //var_dump($action);

        switch($action) {
            case "login":
                $template = new \Template('login.php');
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
                try {
                    $postController = new PostController();
                    $postController->edit($_GET['id'], $_SESSION['userId'], $_SESSION['adminId']);
                } catch(\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "showPost":
                try {
                    $x = new PostController();
                    $x->show($_GET['id'], $_SESSION['userId'], $_SESSION['adminId']);
                } catch(\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "search":
                require_once ('./search.php');
                break;
            case "removePost":
                try {
                    $x = new PostController();
                    $x->remove($_GET['id'], $_SESSION['userId'], $_SESSION['adminId']);
                } catch(\Exception $e) {
                    echo $e->getMessage();
                }
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