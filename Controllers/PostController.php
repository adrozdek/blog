<?php

namespace controller;

use klas;

class PostController
{
    public function show($postId, $userSessionId, $adminId)
    {
        if (isset($postId) && is_numeric($postId)) {
            $postToShow = \klas\Post::LoadPostById($postId);
            $userId = (int)($postToShow->getUserId());
            $user = \klas\User::GetUserById($userId);

            echo("<h1>" . ucfirst($user->getName()) . "</h1>");
            echo($postToShow->getPostText() . "<br />");
            echo($postToShow->getPostDate() . "<br />");
            if (isset($_SESSION['userId'])) {
                if ($userId == $userSessionId || isset($adminId)) {
                    echo sprintf("<a href='%s'>Edit</a><br>", Param::url(false, ['action' => 'editPost', 'id' => $postId]));
                    echo sprintf("<a href='%s'>Remove</a><br>", Param::url(false, ['action' => 'removePost', 'id' => $postId]));
                }
            }
        } else {
            throw new \Exception('Post doesn\'t exist');
        }
    }

    public function remove($postId, $userId, $adminId)
    {
        if (isset($postId) && is_numeric($postId)) {
            if ($postToRemove = \klas\Post::LoadPostById($postId)) {
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
            $postToEdit = \klas\Post::LoadPostById($postId);

            if ($postToEdit->getUserId() == $userId || isset($adminId)) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $post = $_POST['postText'];
                    $title = $_POST['title'];
                    if (Security::SanitizeString($post) && Security::IsValid($post) && Security::SanitizeString($title) && Security::IsValid($title)) {
                        if ($postToEdit->updatePost($title, $post)) {
                            echo("Post updated:");
                        } else {
                            throw new \Exception("Couldn't update post");
                        }
                    } else {
                        throw new \Exception("New post is not valid. Please try again.");
                    }
                }

                $form_action = 'editPost.php?id=' . $postId;
                $title = $postToEdit->getTitle();
                $postText = $postToEdit->getPostText();
                $headline = 'Edit post:';
                require_once('./Template/post_form.php');
            }
        } else {
            throw new \Exception('Access denied');
        }
    }
}