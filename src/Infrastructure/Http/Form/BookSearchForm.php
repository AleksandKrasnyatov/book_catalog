<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use yii\base\Model;

final class BookSearchForm extends Model
{
    public ?string $title = null;
    public ?int $year = null;
    public ?int $authorId = null;

    public function rules(): array
    {
        return [
            ['title', 'trim'],
            ['title', 'string'],
            [['year', 'authorId'], 'integer'],
        ];
    }
}
