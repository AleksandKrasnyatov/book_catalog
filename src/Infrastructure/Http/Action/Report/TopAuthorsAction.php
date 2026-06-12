<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Report;

use app\Application\UseCase\Query\Report\TopAuthorsHandler;
use app\Application\UseCase\Query\Report\TopAuthorsQuery;
use app\Infrastructure\Http\Form\TopAuthorsReportForm;
use Yii;
use yii\base\Action;
use yii\web\Controller;

/**
 * @template-extends Action<Controller>
 */
final class TopAuthorsAction extends Action
{
    public function __construct($id, $controller, private readonly TopAuthorsHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(): string
    {
        $form = new TopAuthorsReportForm();
        $form->load(Yii::$app->request->queryParams);
        $form->validate();

        return $this->controller->render('top-authors', [
            'searchModel' => $form,
            'rows' => $this->handler->handle(new TopAuthorsQuery((int) $form->year)),
        ]);
    }
}
