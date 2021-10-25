<?php

namespace Blog\Controllers;

use Blog\Exceptions\InvalidArgumentException;
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
                $this->view->renderHtml('users/singUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/singUp.php');
    }
}
