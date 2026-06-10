<?php

declare(strict_types=1);

namespace app\Application\Gateway\Sms;

use app\Application\DTO\SmsMessage;

interface SmsGatewayInterface
{
    public function send(SmsMessage $message): void;
}
