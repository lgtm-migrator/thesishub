<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "RoleMapping".
 *
 * @property integer $id
 * @property string $principalType
 * @property string $principalId
 * @property integer $roleId
 */
class RoleMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'RoleMapping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roleId'], 'integer'],
            [['principalType', 'principalId'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'principalType' => 'Principal Type',
            'principalId' => 'Principal ID',
            'roleId' => 'Role ID',
        ];
    }
}
