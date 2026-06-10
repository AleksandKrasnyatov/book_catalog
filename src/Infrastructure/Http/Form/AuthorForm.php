<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use yii\base\Model;

final class AuthorForm extends Model
{
    public ?string $name = null;

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'trim'],
            ['name', 'string', 'max' => 255],
        ];
    }
}

