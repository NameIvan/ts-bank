<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deposits".
 *
 * @property int $id
 * @property int $client_id
 * @property float $start_account
 * @property float $account текущий счёт
 * @property float $rate процент по депозиту
 * @property string $updated_at
 * @property string $created_at
 *
 * @property Clients $client
 * @property DepositsOperations[] $depositsOperations
 */
class Deposits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deposits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'start_account', 'account', 'rate'], 'required'],
            [['client_id'], 'integer'],
            [['start_account', 'account', 'rate'], 'number'],
            [['updated_at', 'created_at'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'start_account' => 'Start Account',
            'account' => 'Account',
            'rate' => 'Rate',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[DepositsOperations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepositsOperations()
    {
        return $this->hasMany(DepositsOperations::className(), ['deposit_id' => 'id']);
    }
}
