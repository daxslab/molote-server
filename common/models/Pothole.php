<?php

namespace common\models;

use Yii;
use sjaakp\spatial\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "pothole".
 *
 * @property int $id
 * @property string $location
 * @property int $reports_count
 * @property string $created_at
 * @property int $active
 *
 * @property Report[] $reports
 *
 */
class Pothole extends ActiveRecord
{

    public static $REPORTS_TRUST_NUMBER = 1;
    public static $POTHOLE_RADIUS = 0.008;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pothole';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location', 'reports_count'], 'required'],
            [['location'], 'string'],
            [['reports_count', 'active'], 'integer'],
            [['created_at'], 'safe'],
            [['active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location' => 'Location',
            'created_at' => 'Created At',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['pothole_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => [],
                ],
                'createdAtAttribute' => 'created_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return PotholeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PotholeQuery(get_called_class());
    }

}