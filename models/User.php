<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface; // ВАЖНО: Без этого не будет работать вход на сайт!

/**
 * Это модель для таблицы "user".
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            // Обязательные поля (исправил опечатку 1fullname на fullname)
            [['organization_id', 'fullname', 'email', 'username', 'pass'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['organization_id'], 'integer', 'message' => 'Значение должно быть целым числом'],
            [['fullname', 'email', 'username', 'pass'], 'string', 'max' => 255, 'message' => 'Максимальная длина — 255 символов'],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id'], 'message' => 'Выбранная организация не существует'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Организация',
            'fullname' => 'ФИО',
            'email' => 'Email',
            'username' => 'Логин',
            'pass' => 'Пароль',
            'role' => 'Роль',
        ];
    }

    // --- ОБЯЗАТЕЛЬНЫЕ МЕТОДЫ ДЛЯ ВХОДА НА САЙТ (IdentityInterface) ---
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null; 
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    // Проверка пароля при входе (сравнивает введенный пароль с хэшем в БД)
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->pass);
    }

    // --- СВЯЗИ ---
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['user_id' => 'id']);
    }
}