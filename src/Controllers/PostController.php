<?php

namespace Controllers;

use Models\User as User;
use Models\Post as Post;
use Checking\Security as Security;
use Service\Template;

class PostController
{
    public function show($postId, $userSessionId, $adminId)
    {
        if (isset($postId) && is_numeric($postId)) {
            echo 'hgh';
            $postToShow = Post::LoadPostById($postId);
            $userId = (int)($postToShow->getUserId());
            $user = User::GetUserById($userId);

            $name = ucfirst($user->getName());
            $postTitle = $postToShow->getTitle();
            $postText = $postToShow->getPostText();
            $postDate = $postToShow->getPostDate();
            $editLink = '';
            $removeLink = '';
            if (isset($_SESSION['userId'])) {
                if ($userId == $userSessionId || isset($adminId)) {
                    /** @noinspection HtmlUnknownTarget */
                    $editLink = sprintf("<a href='%s'>Edit</a><br>", \Param::url(false, ['action' => 'editPost', 'id' => $postId]));
                    /** @noinspection HtmlUnknownTarget */
                    $removeLink = sprintf("<a href='%s'>Remove</a><br>", \Param::url(false, ['action' => 'removePost', 'id' => $postId]));
                }
            }
            echo 'hgh';

            $toReplace = [
                '{{ name }}' => $name,
                '{{ title }}' => $postTitle,
                '{{ postText }}' => $postText,
                '{{ postDate }}' => $postDate,
                '{{ edit }}' => $editLink,
                '{{ remove }}' => $removeLink
            ];

            $template = new Template(__DIR__ . '/../Views/Post/showPost2.php', $toReplace);
            echo $template->render();
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