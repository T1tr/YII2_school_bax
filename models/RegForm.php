<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegForm extends Model
{
    public $fullname;
    public $username;
    public $email;
    public $pass;
    public $password2;
    public $organization_id; // <-- ДОБАВЛЕНО

    public function rules()
    {
        return [
            [['fullname', 'username', 'email', 'pass', 'password2', 'organization_id'], 'required', 'message' => 'Поле обязательно для заполнения'], // Добавили organization_id
            [['fullname', 'username', 'email', 'pass'], 'string', 'max' => 255],
            [['organization_id'], 'integer'], // <-- ДОБАВЛЕНО
            [['email'], 'email', 'message' => 'Введите корректный email'],
            [['password2'], 'compare', 'compareAttribute' => 'pass', 'message' => 'Пароли не совпадают'],
            
            [['username'], 'unique', 'targetClass' => User::className(), 'targetAttribute' => 'username', 'message' => 'Этот логин уже занят'],
            [['email'], 'unique', 'targetClass' => User::className(), 'targetAttribute' => 'email', 'message' => 'Эта почта уже используется'],
            
            // ДОБАВЛЕНО: Проверяем, что выбранная организация существует
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id'], 'message' => 'Выбранная организация не найдена'],
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->fullname = $this->fullname;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->pass = Yii::$app->security->generatePasswordHash($this->pass);
            
            // ИЗМЕНЕНО: Берем ID организации из формы, а не жесткое значение 1
            $user->organization_id = $this->organization_id; 
            
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
}