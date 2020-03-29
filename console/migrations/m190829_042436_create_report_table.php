<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%crowd}}`
 */
class m190829_042436_create_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'location' => 'point not null',
            'device_uuid' => $this->string()->notNull(),
            'crowd_id' => $this->integer()->notNull(),
            'additional_data' => $this->text(),
            'created_at' => $this->datetime()->notNull(),
        ]);

        // creates index for column `crowd_id`
        $this->createIndex(
            '{{%idx-report-crowd_id}}',
            '{{%report}}',
            'crowd_id'
        );

        // add foreign key for table `{{%crowd}}`
        $this->addForeignKey(
            '{{%fk-report-crowd_id}}',
            '{{%report}}',
            'crowd_id',
            '{{%crowd}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%crowd}}`
        $this->dropForeignKey(
            '{{%fk-report-crowd_id}}',
            '{{%report}}'
        );

        // drops index for column `crowd_id`
        $this->dropIndex(
            '{{%idx-report-crowd_id}}',
            '{{%report}}'
        );

        $this->dropTable('{{%report}}');
    }
}
