<?php

declare(strict_types=1);

namespace app\Infrastructure\Gateway\Sms;

use app\Application\DTO\SmsMessage;
use app\Application\Gateway\Sms\SmsGatewayInterface;
use RuntimeException;

final class SmsPilotGateway implements SmsGatewayInterface
{
    public function send(SmsMessage $message): void
    {
        if ($message->phones === []) {
            return;
        }

        $result = sms($message->phones, $message->text);
        if ($result === false) {
            throw new RuntimeException(sms_error() ?: 'Unknown SMSPilot error.');
        }
    }
}
