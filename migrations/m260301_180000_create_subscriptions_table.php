<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 */
class m260301_180000_create_subscriptions_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-subscriptions-author_id',
            '{{%subscriptions}}',
            'author_id'
        );

        $this->createIndex(
            'uniq-subscriptions-author_id-phone',
            '{{%subscriptions}}',
            ['author_id', 'phone'],
            true
        );

        $this->addForeignKey(
            'fk-subscriptions-author_id',
            '{{%subscriptions}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk-subscriptions-author_id', '{{%subscriptions}}');
        $this->dropIndex('uniq-subscriptions-author_id-phone', '{{%subscriptions}}');
        $this->dropIndex('idx-subscriptions-author_id', '{{%subscriptions}}');
        $this->dropTable('{{%subscriptions}}');
    }
}
