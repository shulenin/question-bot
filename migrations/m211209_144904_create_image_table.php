<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 */
class m211209_144904_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->text()->notNull(),
            'img' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image}}');
    }
}
