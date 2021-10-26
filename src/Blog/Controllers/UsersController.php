<?php

namespace Blog\Controllers;

use Blog\Exceptions\InvalidArgumentException;
use Blog\Models\Users\UserActivationService;
use Blog\Services\EmailSender;
use Blog\View\View;
use Blog\Models\Users\User;

class UsersController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

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

                EmailSender::send($user, 'Activation', 'userActivation.php', [
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
        $user = User::getById($userId);
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
            echo 'OK!';
        }
    }
}
