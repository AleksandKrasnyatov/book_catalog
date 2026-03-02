<?php

namespace app\forms;

use app\dto\SubscriptionDto;
use app\models\Author;
use app\models\Subscription;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use yii\base\Model;

class SubscriptionForm extends Model
{
    public $phone;
    public $authorId;

    public function rules(): array
    {
        return [
            [['phone', 'authorId'], 'required'],
            ['authorId', 'integer'],
            [
                'authorId',
                'exist',
                'targetClass' => Author::class,
                'targetAttribute' => ['authorId' => 'id'],
            ],
            /** @see validatePhone */
            ['phone', 'validatePhone'],
            /** @see validateExistingSubscription */
            ['phone', 'validateExistingSubscription'],
        ];
    }

    public function validatePhone(string $attribute): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            // Парсим номер
            $number = $phoneUtil->parse($this->phone);

            // Проверяем валидность
            if (!$phoneUtil->isValidNumber($number)) {
                $this->addError($attribute, 'Неверный номер телефона');
                return;
            }

            if ($phoneUtil->getNumberType($number) !== PhoneNumberType::MOBILE) {
                $this->addError($attribute, 'Подписаться можно только на мобильный номер');
                return;
            }

            // Нормализуем и сохраняем номер в формате E.164
            $this->phone = $phoneUtil->format($number, PhoneNumberFormat::E164);
        } catch (NumberParseException $e) {
            $this->addError($attribute, 'Неверный формат телефона. Пример: +7 999 123-45-67');
        }
    }

    public function validateExistingSubscription(string $attribute): void
    {
        $exists = Subscription::find()
            ->where(['author_id' => $this->authorId, 'phone' => $this->phone])
            ->exists();

        if ($exists) {
            $this->addError($attribute, 'Вы уже подписаны на этого автора.');
        }
    }

    public function toDto(): SubscriptionDto
    {
        return new SubscriptionDto(
            $this->authorId,
            $this->phone
        );
    }
}
