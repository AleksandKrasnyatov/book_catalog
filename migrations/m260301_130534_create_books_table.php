<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m260301_130534_create_books_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer()->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(),
            'photo' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%books}}');
    }
}
