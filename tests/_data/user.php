<?php

$time = time();

return [
    '100' => [
        'id' => 100,
        'username' => 'admin',
        'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
        'auth_key' => 'test100key',
        'email' => 'admin@example.com',
        'created_at' => $time,
        'updated_at' => $time,
    ],
    '101' => [
        'id' => 101,
        'username' => 'demo',
        'password_hash' => Yii::$app->security->generatePasswordHash('demo'),
        'auth_key' => 'test101key',
        'email' => 'demo@example.com',
        'created_at' => $time,
        'updated_at' => $time,
    ],
];
