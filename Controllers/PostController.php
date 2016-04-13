<?php

namespace Controllers;

use Models\User as User;
use Models\Post as Post;
use Checking\Security as Security;
use Checking\Param as Param;

class PostController
{
    public function show($postId, $userSessionId, $adminId)
    {
        if (isset($postId) && is_numeric($postId)) {
            $postToShow = Post::LoadPostById($postId);
            $userId = (int)($postToShow->getUserId());
            $user = User::GetUserById($userId);

            $name =  ucfirst($user->getName());
            $postTitle = $postToShow->getTitle();
            $postText = $postToShow->getPostText();
            $postDate = $postToShow->getPostDate();
            if (isset($_SESSION['userId'])) {
                if ($userId == $userSessionId || isset($adminId)) {
                    $editLink = sprintf("<a href='%s'>Edit</a><br>", Param::url(false, ['action' => 'editPost', 'id' => $postId]));
                    $removeLink = sprintf("<a href='%s'>Remove</a><br>", Param::url(false, ['action' => 'removePost', 'id' => $postId]));
                }
            }
//            require_once dirname(__DIR__) . '/Views/Post/showPost.php';
            $file = fopen(dirname(__DIR__) . '/Views/Post/showPost2.php', 'r');
            $contents = fread($file, filesize(dirname(__DIR__) . '/Views/Post/showPost2.php'));
            $toReplace = ['{{ name }}' => $name, '{{ title }}' => $postTitle, '{{ postText }}' => $postText, '{{ postDate }}' => $postDate];
            $cont2 = str_replace(array_keys($toReplace), array_values($toReplace), $contents);
            echo $cont2;
        } else {
            throw new \Exception('Post doesn\'t exist');
        }
    }

    public function remove($postId, $userId, $adminId)
    {
        if (isset($postId) && is_numeric($postId)) {
            if ($postToRemove = Post::LoadPostById($postId)) {
                if ($postToRemove->getUserId() == $userId || isset($adminId)) {
                    if ($postToRemove->removePost()) {
                        echo('Post removed');
                        return;
                    } else {
                        throw new \Exception('Couldn\'t remove this post');
                    }
                }
                throw new \Exception('Access denied');
            }
        }
    }

    public function edit($postId, $userId, $adminId)
    {
        if (isset($postId) && is_numeric($postId)) {
            $postToEdit = Post::LoadPostById($postId);

            if ($postToEdit->getUserId() == $userId || isset($adminId)) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $post = $_POST['postText'];
                    $title = $_POST['title'];
                    if (Security::SanitizeString($post) && Security::IsValid($post) && Security::SanitizeString($title) && Security::IsValid($title)) {
                        if ($postToEdit->updatePost($title, $post)) {
                            header("Location: ?action=showPost&id=$postId");
                        } else {
                            throw new \Exception("Couldn't update post");
                        }
                    } else {
                        throw new \Exception("New post is not valid. Please try again.");
                    }
                }

                $form_action = "?action=editPost&id=$postId";
                $title = $postToEdit->getTitle();
                $postText = $postToEdit->getPostText();
                $headline = 'Edit post:';
                require_once(dirname(__DIR__) . '/Template/post_form.php');
            }
        } else {
            throw new \Exception('Access denied');
        }
    }
}