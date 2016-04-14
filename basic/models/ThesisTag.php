<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ThesisTag".
 *
 * @property integer $thesis_id
 * @property integer $tag_id
 *
 * @property Thesis $thesis
 * @property Tag $tag
 */
class ThesisTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ThesisTag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thesis_id', 'tag_id'], 'required'],
            [['thesis_id', 'tag_id'], 'integer'],
            [['thesis_id'], 'exist', 'skipOnError' => true, 'targetClass' => Thesis::className(), 'targetAttribute' => ['thesis_id' => 'thesis_id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'tag_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thesis_id' => 'Thesis ID',
            'tag_id' => 'Tag ID',
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
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['tag_id' => 'tag_id']);
    }
}
