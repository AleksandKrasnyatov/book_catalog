<?php

declare(strict_types=1);

namespace app\jobs;

use app\models\Author;
use app\models\Book;
use app\models\Subscription;
use app\services\SmsPilotService;
use Yii;
use yii\queue\JobInterface;

class SendNewBookSmsJob implements JobInterface
{
    public function __construct(
        public int $bookId,
        public int $authorId,
    ) {
    }

    public function execute($queue): void
    {
        echo '123';
        $author = Author::findOne($this->authorId);
        $book = Book::findOne($this->bookId);

        if (!$author || !$book) {
            Yii::error("Unable to send SMS: book_id={$this->bookId}, author_id={$this->authorId} not found.");
            return;
        }

        $phones = Subscription::find()
            ->select('phone')
            ->where(['author_id' => $this->authorId])
            ->column();

        if (empty($phones)) {
            return;
        }

        $text = sprintf('У автора "%s" новая книга: "%s".', $author->name, $book->title);
        new SmsPilotService()->send($phones, $text);

        Yii::info(
            sprintf(
                'Sent new-book SMS for author_id=%d, book_id=%d, subscribers=%d.',
                $this->authorId,
                $this->bookId,
                count($phones)
            )
        );
        echo 'op';
    }
}
