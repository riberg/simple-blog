<?php

namespace Blog\Controllers;

use Blog\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $articles = [
            ['name' => 'Article 1', 'text' => 'Article text 1...'],
            ['name' => 'Article 2', 'text' => 'Article text 2...']
        ];
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => 'Welcome page']);
    }
}