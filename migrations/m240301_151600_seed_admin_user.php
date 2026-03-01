<?php

use yii\db\Migration;

class m240301_151600_seed_admin_user extends Migration
{
    public function safeUp(): void
    {
        $passwordHash = Yii::$app->security->generatePasswordHash('admin123');
        $authKey = Yii::$app->security->generateRandomString();
        $time = time();

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => $passwordHash,
            'auth_key' => $authKey,
            'email' => 'admin@example.com',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }

    public function safeDown(): void
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
    }
}
