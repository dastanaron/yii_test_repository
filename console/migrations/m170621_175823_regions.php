<?php

use yii\db\Migration;
use console\components\PecomAPI;
use console\models\Regions;

class m170621_175823_regions extends Migration
{
    /*public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170621_175823_regions cannot be reverted.\n";

        return false;
    }*/

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('regions', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('regions');
    }

}
