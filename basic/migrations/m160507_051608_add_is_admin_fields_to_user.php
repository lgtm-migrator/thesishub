<?php

use yii\db\Migration;

class m160507_051608_add_is_admin_fields_to_user extends Migration
{
    public function up()
    {
    	$this->addColumn('User', 'is_admin', $this->integer(1));
    }

    public function down()
    {
    	$this->dropColumn('User', 'is_admin');
    }
}
