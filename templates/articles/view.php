<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Author: <?= $article->getAuthor()->getNickname() ?></p><br>
    <br>
    <?php if ($user !== null && $user->isAdmin()): ?>
        <a href="http://blog.loc/articles/<?= $article->getId() ?>/edit">Редактировать</a>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>
