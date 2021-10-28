<?php

namespace Blog\Controllers;

use Blog\Models\Articles\Article;
use Blog\Models\Users\UsersAuthService;

class MainController extends AbstractController
{
    public function main()
    {
        $this->page(1);
    }

    public function page(int $pageNum)
    {
        $this->view->renderHtml('main/main.php', [
            'articles' => Article::getPage($pageNum, 5),
            'user' => UsersAuthService::getUserByToken(),
            'pagesCount' => Article::getPagesCount(5),
            'currentPageNum' => $pageNum,
        ]);
    }
}
