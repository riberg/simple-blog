<?php

namespace Blog\Controllers;

use Blog\Exceptions\NotFoundException;
use Blog\View\View;
use Blog\Models\Users\User;
use Blog\Models\Articles\Article;

class ArticlesController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
        ]);
    }

    public function edit(int $articleId): void
    {
        /** @var Article $article */
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->setName('New article name');
        $article->setText('New article text');

        $article->save();
    }

    public function add(): void
    {
        $author = User::getById(1);

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('New name');
        $article->setText('New text');

        $article->save();
        var_dump($article);
    }

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article !== null) {
            $article->delete();
            $this->view->renderHtml('articles/delete.php');
        } else {
            throw new NotFoundException();
        }
    }
}
