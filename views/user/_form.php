<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Organization; // Подключаем модель организации

/** @var yii\web\View $this */
/** @var app\models\RegForm $model */ // Обрати внимание, тут теперь RegForm, а не User!
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Выпадающий список организаций -->
    <?= $form->field($model, 'organization_id')->dropDownList(
        ArrayHelper::map(Organization::find()->all(), 'id', 'name'),
        ['prompt' => '--- Выберите организацию ---']
    ) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true]) ?>

    <!-- Добавляем повторный ввод пароля (обязательно для RegForm) -->
    <?= $form->field($model, 'password2')->passwordInput(['maxlength' => true])->label('Повторите пароль') ?>

    <div class="form-group">
        <!-- Поменял кнопку на русскую -->
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>