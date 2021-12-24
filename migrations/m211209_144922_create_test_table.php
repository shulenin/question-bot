<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test}}`.
 */
class m211209_144922_create_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test}}', [
            'id' => $this->primaryKey(),
            'chat' => $this->integer()->notNull(),
            'answer_1' => $this->text()->notNull(),
            'answer_2' => $this->text()->notNull(),
            'answer_3' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%test}}');
    }
}
