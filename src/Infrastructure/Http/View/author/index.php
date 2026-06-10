<?php

/** @var \app\Infrastructure\Http\Form\AuthorSearchForm $searchModel */
/** @var \app\Application\UseCase\Query\Book\Model\PaginatedResult $result */

?>
<h1>Авторы</h1>

<?php foreach ($result->items as $author): ?>
    <div><?= htmlspecialchars($author->name, ENT_QUOTES) ?></div>
<?php endforeach; ?>

