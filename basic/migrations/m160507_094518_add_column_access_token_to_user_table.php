<?php

use yii\db\Migration;

/**
 * Handles adding column_access_token to table `user_table`.
 */
class m160507_094518_add_column_access_token_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('User', 'access_token', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('User', 'access_token');
    }
}
