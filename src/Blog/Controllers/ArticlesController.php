<?php

namespace Blog\Controllers;

use Blog\Exceptions\ForbiddenException;
use Blog\Exceptions\InvalidArgumentException;
use Blog\Exceptions\NotFoundException;
use Blog\Exceptions\UnauthorizedException;
use Blog\Models\Articles\Article;

class ArticlesController extends AbstractController
{
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

    public function edit(int $articleId)
    {
        /** @var Article $article */
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Редактировать статью может только администратор');
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('/articles/edit.php', [
                    'error' => $e->getMessage(),
                    'article' => $article
                    ]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function add(): void
    {
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Добавить статью может только администратор');
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/add.php');
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
