<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Subscription;

use app\Application\UseCase\Command\Subscription\SubscribeToAuthorCommand;
use app\Application\UseCase\Command\Subscription\SubscribeToAuthorHandler;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Infrastructure\Http\Form\SubscriptionForm;
use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\Controller;

/**
 * @template-extends Action<Controller>
 */
final class IndexAction extends Action
{
    public function __construct(
        $id,
        $controller,
        private readonly SubscribeToAuthorHandler $handler,
        private readonly AuthorRepositoryInterface $authors,
        $config = [],
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(): Response|string
    {
        $form = new SubscriptionForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->handler->handle(new SubscribeToAuthorCommand((int) $form->authorId, (string) $form->phone));
            Yii::$app->session->setFlash('success', 'Подписка оформлена.');

            return $this->controller->refresh();
        }

        return $this->controller->render('index', [
            'model' => $form,
            'authors' => $this->authors->listOptions(),
        ]);
    }
}
