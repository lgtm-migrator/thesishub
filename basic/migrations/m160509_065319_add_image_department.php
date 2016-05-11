<?php

use yii\db\Migration;

class m160509_065319_add_image_department extends Migration
{
    public function up()
    {
        $this->addColumn('Department', 'image', $this->string(255));
    }

    public function down()
    {
        echo "m160509_065319_add_image_department cannot be reverted.\n";
        $this->dropColumn('Department', 'image');
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
