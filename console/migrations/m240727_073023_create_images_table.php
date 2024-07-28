<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m240727_073023_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'server_name' => $this->string(),
            'type' => $this->string(9),
            'parameter_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
