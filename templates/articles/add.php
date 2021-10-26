<?php include __DIR__ . '/../header.php'; ?>
    <h1>Создние новой статьи</h1>
    <?php if (!empty($error)): ?>
        <dib style="color: red"><?= $error ?></dib>
    <?php endif; ?>
    <form action="/articles/add" method="post">
        <label for="name">Название статьи</label><br>
        <input type="text" name="name" id="name" size="50" value="<?= $_POST['name'] ?? '' ?>"><br>
        <br>
        <label for="text">Текст статьи</label><br>
        <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? '' ?></textarea><br>
        <br>
        <input type="submit" value="Создать">
    </form>
<?php include __DIR__ . '/../footer.php'; ?>
