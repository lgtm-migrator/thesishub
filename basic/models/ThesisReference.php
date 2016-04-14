<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ThesisReference".
 *
 * @property integer $thesis_id
 * @property integer $ref_id
 *
 * @property Reference $ref
 * @property Thesis $thesis
 */
class ThesisReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ThesisReference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thesis_id', 'ref_id'], 'required'],
            [['thesis_id', 'ref_id'], 'integer'],
            [['thesis_id', 'ref_id'], 'unique', 'targetAttribute' => ['thesis_id', 'ref_id'], 'message' => 'The combination of Thesis ID and Ref ID has already been taken.'],
            [['ref_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['ref_id' => 'ref_id']],
            [['thesis_id'], 'exist', 'skipOnError' => true, 'targetClass' => Thesis::className(), 'targetAttribute' => ['thesis_id' => 'thesis_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thesis_id' => 'Thesis ID',
            'ref_id' => 'Ref ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRef()
    {
        return $this->hasOne(Reference::className(), ['ref_id' => 'ref_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesis()
    {
        return $this->hasOne(Thesis::className(), ['thesis_id' => 'thesis_id']);
    }
}
