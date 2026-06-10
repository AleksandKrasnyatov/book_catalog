<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use yii\base\Model;

final class AuthorSearchForm extends Model
{
    public ?string $name = null;

    public function rules(): array
    {
        return [
            ['name', 'trim'],
            ['name', 'string'],
        ];
    }
}
