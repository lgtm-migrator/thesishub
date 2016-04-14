<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Reference".
 *
 * @property integer $ref_id
 * @property string $name
 * @property string $url
 * @property string $author
 * @property integer $year
 * @property string $detail
 *
 * @property ThesisReference[] $thesisReferences
 * @property Thesis[] $theses
 */
class Reference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'author', 'year', 'detail'], 'required'],
            [['year'], 'integer'],
            [['detail'], 'string'],
            [['name', 'url', 'author'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ref_id' => 'Ref ID',
            'name' => 'Name',
            'url' => 'Url',
            'author' => 'Author',
            'year' => 'Year',
            'detail' => 'Detail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesisReferences()
    {
        return $this->hasMany(ThesisReference::className(), ['ref_id' => 'ref_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheses()
    {
        return $this->hasMany(Thesis::className(), ['thesis_id' => 'thesis_id'])->viaTable('ThesisReference', ['ref_id' => 'ref_id']);
    }
}
