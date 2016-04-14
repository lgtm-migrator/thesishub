<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $subject
 * @property integer $is_lecture
 *
 * @property Comment[] $comments
 * @property Rating[] $ratings
 * @property ThesisMapping[] $thesisMappings
 * @property Thesis[] $theses
 * @property UserRole[] $userRoles
 * @property Role[] $roles
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_lecture'], 'integer'],
            [['username', 'password', 'name'], 'string', 'max' => 250],
            [['subject'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'subject' => 'Subject',
            'is_lecture' => 'Is Lecture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesisMappings()
    {
        return $this->hasMany(ThesisMapping::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheses()
    {
        return $this->hasMany(Thesis::className(), ['thesis_id' => 'thesis_id'])->viaTable('ThesisMapping', ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['role_id' => 'role_id'])->viaTable('UserRole', ['user_id' => 'user_id']);
    }
}
