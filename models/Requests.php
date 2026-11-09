<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requests".
 *
 * @property int $id
 * @property int $user_id
 * @property int $recipien_id
 * @property int $service_id
 * @property string $description
 * @property string $status
 *
 * @property Organization $recipien
 * @property Category $service
 * @property User $user
 */
class Requests extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 'Новая'],
            [['user_id', 'recipien_id', 'service_id', 'description'], 'required'],
            [['user_id', 'recipien_id', 'service_id'], 'integer'],
            [['status'], 'string'],
            [['description'], 'string', 'max' => 255],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['service_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['recipien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['recipien_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'recipien_id' => 'Recipien ID',
            'service_id' => 'Service ID',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Recipien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipien()
    {
        return $this->hasOne(Organization::class, ['id' => 'recipien_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Category::class, ['id' => 'service_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
