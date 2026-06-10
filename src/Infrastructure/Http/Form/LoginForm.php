<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use yii\base\Model;

final class LoginForm extends Model
{
    public ?string $username = null;
    public ?string $password = null;
    public bool $rememberMe = true;

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }
}

