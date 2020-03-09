<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deposits_operations".
 *
 * @property int $id
 * @property int $deposit_id
 * @property int $type 1 - Начисление процентов, 2 - Комиссия
 * @property float $value текущий счёт
 * @property string $date
 * @property string $created_at
 *
 * @property Deposits $deposit
 */
class DepositsOperations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deposits_operations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deposit_id', 'type', 'value', 'date'], 'required'],
            [['deposit_id', 'type'], 'integer'],
            [['value'], 'number'],
            [['date', 'created_at'], 'safe'],
            [['deposit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Deposits::className(), 'targetAttribute' => ['deposit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deposit_id' => 'Deposit ID',
            'type' => 'Type',
            'value' => 'Value',
            'date' => 'Date',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Deposit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeposit()
    {
        return $this->hasOne(Deposits::className(), ['id' => 'deposit_id']);
    }
}
