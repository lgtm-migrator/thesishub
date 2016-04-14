<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tag".
 *
 * @property integer $tag_id
 * @property string $name
 *
 * @property ThesisTag[] $thesisTags
 * @property Thesis[] $theses
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesisTags()
    {
        return $this->hasMany(ThesisTag::className(), ['tag_id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheses()
    {
        return $this->hasMany(Thesis::className(), ['thesis_id' => 'thesis_id'])->viaTable('ThesisTag', ['tag_id' => 'tag_id']);
    }
}
