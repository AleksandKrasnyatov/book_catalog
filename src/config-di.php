<?php

declare(strict_types=1);

use app\Application\Gateway\Db\TransactionManagerInterface;
use app\Application\Gateway\File\FileStorageInterface;
use app\Application\Gateway\Notification\NewBookNotifierInterface;
use app\Application\Gateway\Sms\SmsGatewayInterface;
use app\Domain\Query\AuthorQueryInterface;
use app\Domain\Query\BookQueryInterface;
use app\Domain\Query\PhotoUrlGeneratorInterface;
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
use yii\di\Container;

return static function (Container $container): void {
    $container->set(AuthorRepositoryInterface::class, AuthorRepository::class);
    $container->set(BookRepositoryInterface::class, BookRepository::class);
    $container->set(BookAuthorRepositoryInterface::class, BookAuthorRepository::class);
    $container->set(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);

    $container->set(AuthorQueryInterface::class, AuthorQuery::class);
    $container->set(BookQueryInterface::class, BookQuery::class);
    $container->set(ReportQueryInterface::class, ReportQuery::class);

    $container->set(TransactionManagerInterface::class, YiiTransactionManager::class);
    $container->set(NewBookNotifierInterface::class, YiiNewBookNotifier::class);
    $container->set(SmsGatewayInterface::class, SmsPilotGateway::class);
    $container->set(PhotoUrlGeneratorInterface::class, WebPhotoUrlGenerator::class);

    $container->set(FileStorageInterface::class, static fn() => new LocalFileStorage(
        Yii::getAlias('@webroot/photos'),
        new RandomFileNameGenerator(),
    ));
};

