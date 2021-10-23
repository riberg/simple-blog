<?php

namespace Blog\Controllers;

use Blog\Models\Articles\Article;
use Blog\View\View;
use Blog\Services\Db;

class MainController
{
    /** @var View */
    private $view;

    /** @var Db */
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function main()
    {
        $articles = $this->db->query('SELECT * FROM `articles`', [], Article::class);
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}
