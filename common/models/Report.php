<?php

namespace common\models;

use Yii;
use sjaakp\spatial\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property string $location
 * @property string $device_uuid
 * @property int $crowd_id
 * @property string $additional_data
 * @property string $created_at
 *
 * @property Crowd $crowd
 *
 */
class Report extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location', 'crowd_id'], 'required'],
            [['location', 'additional_data'], 'string'],
            [['crowd_id'], 'integer'],
            [['created_at'], 'safe'],
            [['device_uuid'], 'string', 'max' => 255],
            [['crowd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Crowd::className(), 'targetAttribute' => ['crowd_id' => 'id']],
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
            'device_uuid' => 'Device Uuid',
            'crowd_id' => 'Crowd ID',
            'additional_data' => 'Additional Data',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrowd()
    {
        return $this->hasOne(Crowd::className(), ['id' => 'crowd_id']);
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
     * @return ReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReportQuery(get_called_class());
    }
}
