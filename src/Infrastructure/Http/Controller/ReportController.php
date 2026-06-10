<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Controller;

use app\Infrastructure\Http\Action\Report\TopAuthorsAction;
use yii\web\Controller;

final class ReportController extends Controller
{
    public function actions(): array
    {
        return [
            'top-authors' => TopAuthorsAction::class,
        ];
    }
}

