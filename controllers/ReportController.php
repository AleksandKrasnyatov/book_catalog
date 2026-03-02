<?php

declare(strict_types=1);

namespace app\controllers;

use app\forms\TopAuthorsReportSearchForm;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new TopAuthorsReportSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('top-authors', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
