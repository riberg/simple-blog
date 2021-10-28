<?php

namespace Blog\Controllers;

use Blog\Models\Users\User;
use Blog\Models\Users\UsersAuthService;
use Blog\View\View;

abstract class AbstractController
{
    /** @var View */
    protected $view;

    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
    }

    protected function getInputData()
    {
        return json_decode(
            file_get_contents('php://input'),
            true
        );
    }
}