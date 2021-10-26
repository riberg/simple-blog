<?php

namespace Blog\Controllers;

use Blog\Models\Articles\Article;
use Blog\Models\Users\UsersAuthService;

class MainController extends AbstractController
{
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', [
            'articles' => $articles,
            'user' => UsersAuthService::getUserByToken()
        ]);
    }
}
