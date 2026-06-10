<?php

/** @var \app\Application\UseCase\Query\Book\Model\BookView $model */

?>
<h1><?= htmlspecialchars($model->title, ENT_QUOTES) ?></h1>

<?php if ($model->photoUrl): ?>
    <img src="<?= htmlspecialchars($model->photoUrl, ENT_QUOTES) ?>" alt="">
<?php endif; ?>

