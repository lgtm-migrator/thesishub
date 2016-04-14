<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Group".
 *
 * @property integer $group_id
 * @property string $group_name
 *
 * @property GroupRole[] $groupRoles
 * @property Role[] $roles
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'group_name' => 'Group Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupRoles()
    {
        return $this->hasMany(GroupRole::className(), ['group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['role_id' => 'role_id'])->viaTable('GroupRole', ['group_id' => 'group_id']);
    }
}
