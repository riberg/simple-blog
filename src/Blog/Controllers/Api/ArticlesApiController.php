<?php

namespace Blog\Controllers\Api;

use Blog\Controllers\AbstractController;
use Blog\Exceptions\NotFoundException;
use Blog\Models\Articles\Article;
use Blog\Models\Users\User;

class ArticlesApiController extends AbstractController
{
    /**
     * @throws NotFoundException
     */
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->displayJson([
            'article' => [$article]
        ]);
    }

    public function add()
    {
        $input = $this->getInputData();
        $articleFromRequest = $input['articles'][0];

        $authorId = $articleFromRequest['author_id'];
        $author = User::getById($authorId);

        $article = Article::createFromArray($articleFromRequest, $author);
        $article->save();

        header('Location: /api/articles/' . $article->getId(), true, 302);
    }
}