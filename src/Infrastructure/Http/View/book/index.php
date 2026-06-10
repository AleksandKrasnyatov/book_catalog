<?php

/** @var \app\Infrastructure\Http\Form\BookSearchForm $searchModel */
/** @var \app\Application\UseCase\Query\Book\Model\PaginatedResult $result */
/** @var array<int, string> $authors */

?>
<h1>Книги</h1>

<?php foreach ($result->items as $book): ?>
    <div><?= htmlspecialchars($book->title, ENT_QUOTES) ?></div>
<?php endforeach; ?>

