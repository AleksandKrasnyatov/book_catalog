<?php

declare(strict_types=1);

namespace app\behaviors;

use app\jobs\SendNewBookSmsJob;
use app\models\BookAuthor;
use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\BaseActiveRecord;

class NotifySubscribersBehavior extends Behavior
{
    public function events(): array
    {
        return [
            /** @see self::afterInsert() */
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
        ];
    }

    public function afterInsert(Event $event): void
    {
        $bookAuthor = $this->owner;
        if (!$bookAuthor instanceof BookAuthor) {
            return;
        }

        /** @phpstan-ignore-next-line  */
        Yii::$app->queue->push(new SendNewBookSmsJob(
            $bookAuthor->book_id,
            $bookAuthor->author_id
        ));
    }
}
