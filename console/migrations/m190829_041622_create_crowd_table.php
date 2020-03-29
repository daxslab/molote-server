<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crowd}}`.
 */
class m190829_041622_create_crowd_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crowd}}', [
            'id' => $this->primaryKey(),
            'location' => 'point not null',
            'reports_count' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'active' => $this->boolean()->defaultValue(1)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crowd}}');
    }
}
