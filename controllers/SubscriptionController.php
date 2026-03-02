<?php

declare(strict_types=1);

namespace app\controllers;

use app\forms\SubscriptionForm;
use app\models\Author;
use app\services\SubscriptionService;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SubscriptionController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly SubscriptionService $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * @throws Exception
     */
    public function actionIndex(): Response|string
    {
        $form = new SubscriptionForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->subscribe($form);
            Yii::$app->session->setFlash('success', 'Подписка оформлена.');
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $form,
            'authors' => Author::getList(),
        ]);
    }
}
