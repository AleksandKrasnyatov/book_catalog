<?php

declare(strict_types=1);

namespace app\controllers;

use app\forms\BookForm;
use app\forms\BookSearchForm;
use app\models\Author;
use app\services\BookService;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class BookController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly BookService $service,
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
        $searchModel = new BookSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'authors' => Author::getList(),
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
     * @throws Throwable
     */
    public function actionCreate(): Response|string
    {
        $form = new BookForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = $this->service->create($form);
            Yii::$app->session->setFlash('success', 'Книга создана.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $form,
            'authors' => Author::getList(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->service->get($id);
        $form = new BookForm($model);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->update($model, $form);
            Yii::$app->session->setFlash('success', 'Книга обновлена.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $form,
            'book' => $model,
            'authors' => Author::getList(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $this->service->deleteBook($id);
        Yii::$app->session->setFlash('success', 'Книга удалена.');
        return $this->redirect(['index']);
    }
}
