<?php

namespace Agata\Controllers;

use Agata\Core\Controller;
use Agata\Models\Admin;
use Agata\Models\User;
use Agata\Services\Param;
use Agata\Services\Security;
use Agata\Services\Template;

class UserController extends Controller
{
    public function login()
    {
        if (!$this->checkIfUserSessionExist()) {
            $loginUrl = Param::url(false, ['action' => 'login']);
            $registerUrl = Param::url(false, ['action' => 'register']);
            $form_action = $loginUrl;

            $toReplace = [
                '{{ action }}' => $form_action,
                '{{ register }}' => $registerUrl
            ];
            $template = new Template(__DIR__ . '/../Views/User/login_form.php', $toReplace);
            echo $template->render();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $this->isValid($this->sanitizeString($_POST['email']));
                $password = $this->isValid($this->sanitizeString(($_POST['password'])));

                if ($email && $password) {
                    $user = User::LogInUser($email, $password);
                    if ($user != false ) {
                        $_SESSION['userId'] = $user->getId();
                        header("Location: $loginUrl"); //@TODO zmienić przeniesienie
                    }else {
                        echo("Wrong email or password.");
                    }
                }
            }
        } else {
//            $defaultUrl = Param::url(false, ['action' => 'default']);
//            header("Location: $defaultUrl");
            echo 'sesja istenije'; //@TODO zmienić przeniesienie
        }
    }

    public function register()
    {

    }

    public function logout()
    {
        unset($_SESSION['userId']);
        $url = Param::url(false, ['action' => 'login']);
        header("Location: $url");
    }


}