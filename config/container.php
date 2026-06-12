<?php

declare(strict_types=1);

use app\Application\Gateway\Db\TransactionManagerInterface;
use app\Application\Gateway\File\FileStorageInterface;
use app\Application\Gateway\File\PhotoUrlGeneratorInterface;
use app\Application\Gateway\Notification\NewBookNotifierInterface;
use app\Application\Gateway\Sms\SmsGatewayInterface;
use app\Domain\Query\AuthorQueryInterface;
use app\Domain\Query\BookQueryInterface;
use app\Domain\Query\ReportQueryInterface;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\Repository\BookAuthorRepositoryInterface;
use app\Domain\Repository\BookRepositoryInterface;
use app\Domain\Repository\SubscriptionRepositoryInterface;
use app\Infrastructure\Gateway\Db\YiiTransactionManager;
use app\Infrastructure\Gateway\File\LocalFileStorage;
use app\Infrastructure\Gateway\File\RandomFileNameGenerator;
use app\Infrastructure\Gateway\File\WebPhotoUrlGenerator;
use app\Infrastructure\Gateway\Notification\YiiNewBookNotifier;
use app\Infrastructure\Gateway\Sms\SmsPilotGateway;
use app\Infrastructure\Persistence\Query\AuthorQuery;
use app\Infrastructure\Persistence\Query\BookQuery;
use app\Infrastructure\Persistence\Query\ReportQuery;
use app\Infrastructure\Persistence\Repository\AuthorRepository;
use app\Infrastructure\Persistence\Repository\BookAuthorRepository;
use app\Infrastructure\Persistence\Repository\BookRepository;
use app\Infrastructure\Persistence\Repository\SubscriptionRepository;

return [
    'singletons' => [
        AuthorRepositoryInterface::class => AuthorRepository::class,
        BookRepositoryInterface::class => BookRepository::class,
        BookAuthorRepositoryInterface::class => BookAuthorRepository::class,
        SubscriptionRepositoryInterface::class => SubscriptionRepository::class,

        AuthorQueryInterface::class => AuthorQuery::class,
        BookQueryInterface::class => BookQuery::class,
        ReportQueryInterface::class => ReportQuery::class,

        TransactionManagerInterface::class => YiiTransactionManager::class,
        NewBookNotifierInterface::class => static fn(): YiiNewBookNotifier => new YiiNewBookNotifier(
            Yii::$app->get('queue'),
        ),
        SmsGatewayInterface::class => SmsPilotGateway::class,
        PhotoUrlGeneratorInterface::class => WebPhotoUrlGenerator::class,

        FileStorageInterface::class => static fn(): LocalFileStorage => new LocalFileStorage(
            Yii::getAlias('@webroot/photos'),
            new RandomFileNameGenerator(),
        ),
    ],
];
