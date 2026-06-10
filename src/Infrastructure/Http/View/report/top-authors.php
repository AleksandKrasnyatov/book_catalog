<?php

/** @var \app\Infrastructure\Http\Form\TopAuthorsReportForm $searchModel */
/** @var \app\Application\UseCase\Query\Report\Model\TopAuthorRow[] $rows */

?>
<h1>Топ авторов</h1>

<?php foreach ($rows as $row): ?>
    <div><?= htmlspecialchars($row->name, ENT_QUOTES) ?>: <?= $row->booksCount ?></div>
<?php endforeach; ?>

