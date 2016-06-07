<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Thesis".
 *
 * @property integer $thesis_id
 * @property string $thesis_name
 * @property string $intro
 * @property string $score_instructor
 * @property string $score_reviewer
 * @property string $score_council
 * @property string $score_total
 * @property integer $have_disk
 * @property integer $counter
 * @property string $created
 * @property string $status
 * @property string $note
 * @property string $department_id
 * @property double $star_rate 
 * @property integer $star_rate_count 
 *
 * @property Attachment[] $attachments
 * @property Comment[] $comments
 * @property Rating[] $ratings
 * @property Department $department
 * @property ThesisMapping[] $thesisMappings
 * @property User[] $users
 * @property ThesisReference[] $thesisReferences
 * @property Reference[] $refs
 * @property ThesisTag[] $thesisTags
 * @property Tag[] $tags
 */
class Thesis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Thesis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thesis_name', 'department_id'], 'required'],
            [['intro', 'note'], 'string'],
            [['score_instructor', 'score_reviewer', 'score_council', 'score_total', 'star_rate'], 'number'],
            [['have_disk', 'counter', 'star_rate_count'], 'integer'],
            [['created'], 'safe'],
            [['thesis_name'], 'string', 'max' => 250],
            [['status'], 'string', 'max' => 25],
            [['department_id'], 'string', 'max' => 10],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'department_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thesis_id' => 'Thesis ID',
            'thesis_name' => 'Thesis Name',
            'intro' => 'Intro',
            'score_instructor' => 'Score Instructor',
            'score_reviewer' => 'Score Reviewer',
            'score_council' => 'Score Council',
            'score_total' => 'Score Total',
            'have_disk' => 'Have Disk',
            'counter' => 'Counter',
            'created' => 'Created',
            'status' => 'Status',
            'note' => 'Note',
            'department_id' => 'Department ID',
           'star_rate' => 'Star Rate', 
           'star_rate_count' => 'Star Rate Count', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['department_id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesisMappings()
    {
        return $this->hasMany(ThesisMapping::className(), ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_id' => 'user_id'])->viaTable('ThesisMapping', ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesisReferences()
    {
        return $this->hasMany(ThesisReference::className(), ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefs()
    {
        return $this->hasMany(Reference::className(), ['ref_id' => 'ref_id'])->viaTable('ThesisReference', ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesisTags()
    {
        return $this->hasMany(ThesisTag::className(), ['thesis_id' => 'thesis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['tag_id' => 'tag_id'])->viaTable('ThesisTag', ['thesis_id' => 'thesis_id']);
    }
}
