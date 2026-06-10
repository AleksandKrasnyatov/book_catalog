<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use app\Infrastructure\Persistence\ActiveRecord\User;
use Yii;
use yii\base\Model;

final class LoginForm extends Model
{
    public ?string $username = null;
    public ?string $password = null;
    public bool $rememberMe = true;

    private User|false|null $user = false;

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if (!$user || !$user->validatePassword((string) $this->password)) {
            $this->addError($attribute, 'Incorrect username or password.');
        }
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    private function getUser(): ?User
    {
        if ($this->user === false) {
            $this->user = User::findByUsername((string) $this->username);
        }

        return $this->user instanceof User ? $this->user : null;
    }
}
