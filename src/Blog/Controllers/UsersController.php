<?php

namespace Blog\Controllers;

use Blog\Exceptions\ActivationException;
use Blog\Exceptions\InvalidArgumentException;
use Blog\Models\Users\UserActivationService;
use Blog\Models\Users\UsersAuthService;
use Blog\Services\EmailSender;
use Blog\Models\Users\User;

class UsersController extends AbstractController
{
    public function singUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::singUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/singUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/singUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/singUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {
        try {
            $user = User::getById($userId);
            if ($user === null) {
                throw new ActivationException('Такого пользователя не существует');
            }

            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
            if (!$isCodeValid) {
                throw new ActivationException('Неверный код активации');
            }

            if ($isCodeValid) {
                $user->activate();
                $this->view->renderHtml('users/successfulActivation.php', []);
                UserActivationService::deleteActivationCode($user, $activationCode);
                return;
            }
        } catch (ActivationException $e) {
            $this->view->renderHtml('users/failedActivation.php', ['error' => $e->getMessage()]);
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        UsersAuthService::deleteToken();
        header('Location: /');
    }
}
