<?php

declare(strict_types=1);

namespace app\controllers;

use app\forms\AuthorForm;
use app\forms\AuthorSearchForm;
use app\services\AuthorService;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class AuthorController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly AuthorService $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $searchModel = new AuthorSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->service->get($id),
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): string|Response
    {
        $form = new AuthorForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = $this->service->create($form);
            Yii::$app->session->setFlash('success', 'Автор создан.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionUpdate(int $id): string|Response
    {
        $model = $this->service->get($id);
        $form = new AuthorForm($model);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->update($model, $form);
            Yii::$app->session->setFlash('success', 'Автор обновлен.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $form,
            'author' => $model,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $this->service->deleteAuthor($id);
        Yii::$app->session->setFlash('success', 'Автор удален.');
        return $this->redirect(['index']);
    }
}
