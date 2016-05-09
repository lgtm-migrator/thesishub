<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Department".
 *
 * @property string $department_id
 * @property string $department_name
 * @property string $department_description
 *
 * @property Thesis[] $theses
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id'], 'required'],
            [['department_description'], 'string'],
            [['department_id'], 'string', 'max' => 10],
            [['department_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_id' => 'Department ID',
            'department_name' => 'Department Name',
            'department_description' => 'Department Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheses()
    {
        return $this->hasMany(Thesis::className(), ['department_id' => 'department_id']);
    }

    public function fields()
    {
        return [
            // field name is the same as the attribute name
            'department_id',
            // field name is "email", the corresponding attribute name is "email_address"
            'department_name',
            'department_description',
            'thesis' => function($model) {
                return $model->theses;
            }
        ];
    }

    public function extraFields()
    {
        return ['theses'];
    }
}
