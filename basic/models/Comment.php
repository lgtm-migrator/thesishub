<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Comment".
 *
 * @property integer $comment_id
 * @property integer $thesis_id
 * @property integer $user_id
 * @property string $content
 * @property string $created
 *
 * @property Thesis $thesis
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thesis_id', 'user_id'], 'integer'],
            [['content'], 'string'],
            [['created'], 'safe'],
            [['thesis_id'], 'exist', 'skipOnError' => true, 'targetClass' => Thesis::className(), 'targetAttribute' => ['thesis_id' => 'thesis_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'thesis_id' => 'Thesis ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesis()
    {
        return $this->hasOne(Thesis::className(), ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
