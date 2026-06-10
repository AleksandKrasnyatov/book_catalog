<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use yii\base\Model;

final class SubscriptionForm extends Model
{
    public ?string $phone = null;
    public ?int $authorId = null;

    public function rules(): array
    {
        return [
            [['phone', 'authorId'], 'required'],
            ['authorId', 'integer'],
            /** @see self::validatePhone() */
            ['phone', 'validatePhone'],
        ];
    }

    public function validatePhone(string $attribute): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $number = $phoneUtil->parse((string) $this->phone);
            if (!$phoneUtil->isValidNumber($number) || $phoneUtil->getNumberType($number) !== PhoneNumberType::MOBILE) {
                $this->addError($attribute, 'Неверный мобильный номер телефона.');
                return;
            }

            $this->phone = $phoneUtil->format($number, PhoneNumberFormat::E164);
        } catch (NumberParseException) {
            $this->addError($attribute, 'Неверный формат телефона. Пример: +7 999 123-45-67');
        }
    }
}

