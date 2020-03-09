<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $identification
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $birthday
 * @property string $created_at
 *
 * @property Deposits[] $deposits
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identification', 'first_name', 'last_name', 'gender', 'birthday'], 'required'],
            [['gender'], 'string'],
            [['birthday', 'created_at'], 'safe'],
            [['identification'], 'string', 'max' => 64],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['identification'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identification' => 'Identification',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Deposits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposits::className(), ['client_id' => 'id']);
    }
}
