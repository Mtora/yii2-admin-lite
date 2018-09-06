<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
app\assets\AdminProAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.png">
    <!-- Bootstrap Core CSS -->
    <link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- page css -->
    <link href="/css/pages/login-register-lock.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
