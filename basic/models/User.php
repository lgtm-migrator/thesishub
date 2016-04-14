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
 * @property integer $is_admin 
 *
 * @property Comment[] $comments
 * @property Rating[] $ratings
 * @property ThesisMapping[] $thesisMappings
 * @property Thesis[] $theses
 * @property UserRole[] $userRoles
 * @property Role[] $roles
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    private static $_instance;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->password = $this->encryptPassword($this->password);
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_lecture', 'is_admin'], 'integer'],
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
            'is_admin' => 'Is Admin', 
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

    public static function findByUsername($username) 
    {   
        if (!self::$_instance) self::$_instance = new self();

        return self::$_instance->find()->where(['username' => $username])->one();
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['access_token' => $token]);
        return null;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        // return $this->authKey;
        return '';
    }

    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
        return false;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $this->encryptPassword($password);
    }

    public function encryptPassword($password) {
        return md5(md5($password) . 'asas');
    }
}