<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
   $items = [];

    $items[] = ['label' => 'Главная', 'url' => ['/site/index']];
    $items[] = ['label' => 'Контакты', 'url' => ['/site/about']];

    if (Yii::$app->user->isGuest) {
        // Для гостей
        $items[] = ['label' => 'Регистрация', 'url' => ['/user/create']];
        $items[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
        // Для авторизованных (проверяем поле role из вашей БД)
        if (Yii::$app->user->identity->role === 'admin') {
            // Меню Админа
            $items[] = ['label' => 'Все заявки', 'url' => ['/requests/index']];
            $items[] = ['label' => 'Категории услуг', 'url' => ['/category/index']];
            $items[] = ['label' => 'Пользователи', 'url' => ['/user/index']];
        } else {
            // Меню обычного пользователя
            $items[] = ['label' => 'Мои заявки', 'url' => ['/requests/index']];
            $items[] = ['label' => 'Создать заявку', 'url' => ['/requests/create']];
        }

        // Кнопка выхода (оставил как у вас)
        $items[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')', 
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    // Вывод меню (эта строчка должна быть после закрывающей скобки else)
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
