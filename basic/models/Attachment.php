<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Attachment".
 *
 * @property integer $attachment_id
 * @property integer $thesis_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $url
 * @property string $limitation
 * @property integer $visible
 * @property string $created
 *
 * @property Thesis $thesis
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thesis_id', 'visible'], 'integer'],
            [['description'], 'string'],
            [['created'], 'safe'],
            [['name', 'url', 'limitation'], 'string', 'max' => 250],
            [['type'], 'string', 'max' => 25],
            [['thesis_id'], 'exist', 'skipOnError' => true, 'targetClass' => Thesis::className(), 'targetAttribute' => ['thesis_id' => 'thesis_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => 'Attachment ID',
            'thesis_id' => 'Thesis ID',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
            'url' => 'Url',
            'limitation' => 'Limitation',
            'visible' => 'Visible',
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
}
