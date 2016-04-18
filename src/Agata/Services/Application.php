<?php

namespace Agata\Services;

use Agata\Controllers\PostController;
use Agata\Controllers\UserController;
use TreeRoute\Router;

class Application
{
    /**
     *
     */
    public function start()
    {
        $param = new Param();
        $action = $param::getParam('action', false);
        
        switch ($action) {
            case "login":
                try {
                    $userController = new UserController();
                    $userController->login();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "logout":
                try {
                    $userController = new UserController();
                    $userController->logout();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "bloggers":
                require_once('./bloggers.php');
                break;
            case "newPost":
                require_once('./newPost.php');
                break;
            case "register":
                try {
                    $userController = new UserController();
                    $userController->register();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "editComment":
                require_once('./editComment.php');
                break;
            case "editPost":
                try {
                    $postController = new PostController();
                    $postController->edit($_GET['id'], $_SESSION['userId'], $_SESSION['adminId']);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "showPost":
                try {
                    $x = new PostController();
                    $x->show($_GET['id'], 0, 0);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "search":
                require_once('./search.php');
                break;
            case "removePost":
                try {
                    $x = new PostController();
                    $x->remove($_GET['id'], $_SESSION['userId'], $_SESSION['adminId']);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case "profile":
                require_once('./profile.php');
                break;
            default:
                require_once('./default.php');
                break;
        }
    }
}