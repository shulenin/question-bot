<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_data}}`.
 */
class m211205_132045_create_request_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_data}}', [
            'id' => $this->primaryKey(),
            'data_json' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request_data}}');
    }
}
