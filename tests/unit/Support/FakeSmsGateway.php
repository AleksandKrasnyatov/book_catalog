<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Application\DTO\SmsMessage;
use app\Application\Gateway\Sms\SmsGatewayInterface;

final class FakeSmsGateway implements SmsGatewayInterface
{
    /** @var SmsMessage[] */
    public array $sent = [];

    public function send(SmsMessage $message): void
    {
        $this->sent[] = $message;
    }
}
