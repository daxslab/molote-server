<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%pothole}}`
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
            'pothole_id' => $this->integer()->notNull(),
            'additional_data' => $this->text(),
            'created_at' => $this->datetime()->notNull(),
        ]);

        // creates index for column `pothole_id`
        $this->createIndex(
            '{{%idx-report-pothole_id}}',
            '{{%report}}',
            'pothole_id'
        );

        // add foreign key for table `{{%pothole}}`
        $this->addForeignKey(
            '{{%fk-report-pothole_id}}',
            '{{%report}}',
            'pothole_id',
            '{{%pothole}}',
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
        // drops foreign key for table `{{%pothole}}`
        $this->dropForeignKey(
            '{{%fk-report-pothole_id}}',
            '{{%report}}'
        );

        // drops index for column `pothole_id`
        $this->dropIndex(
            '{{%idx-report-pothole_id}}',
            '{{%report}}'
        );

        $this->dropTable('{{%report}}');
    }
}
