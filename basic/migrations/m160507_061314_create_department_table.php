<?php

use yii\db\Migration;

class m160507_061314_create_department_table extends Migration
{
    public function up()
    {
        $this->createTable('Department', [
            'department_id' => $this->string(10)->notNull(),
            'department_name' => $this->string(45),
            'department_description' => $this->text(),
        ]);

        $this->addPrimaryKey('pk_Department_department_id', 'Department', 'department_id');

        $this->addColumn('Thesis', 'department_id', $this->string(10));
        
        // Create index for Thesis.department_id
        $this->createIndex(
            'idx-thesis-department_id',
            'Thesis',
            'department_id'
        );

        $this->addForeignKey(
            'fk_Thesis_1_Department',
            'Thesis',
            'department_id',
            'Department',
            'department_id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_Thesis_1_Department', 'Thesis');
        $this->dropIndex('idx-thesis-department_id', 'Thesis');
        $this->dropColumn('Thesis', 'department_id');
        $this->dropTable('Department');
    }
}
