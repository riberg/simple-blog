<?php include __DIR__ . '/../header.php'; ?>
<?php foreach ($articles as $article): ?>
    <h2><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
    <p><?= $article->getText() ?></p>
    <hr>
    <?php if ($user !== null && $user->isAdmin()): ?>
        <a href="http://blog.loc/articles/add">Создать</a>
    <?php endif; ?>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.php'; ?>
