<?php
use yii\helpers\Html;

app\assets\AppAsset::register($this);
app\assets\AdminProAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="fix-header fix-sidebar card-no-border">
<?php $this->beginBody() ?>
<div id="main-wrapper">

    <?= $this->render(
        'header.php',
        ['usr' => \app\models\User::findOne(Yii::$app->user->getId())->toArray()['username']]
    ) ?>

    <?php
        $pss = [];
        if(Yii::$app->user->identity->isSuperAdmin()){
            $param = Yii::$app->authManager->getPermissions();
        }else{
            $param = Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->getId());
        }
        foreach($param as $ps) {
            $pss[] = $ps->name;
        }
    ?>
    <?= $this->render(
        'left.php',
        ['left' => $pss]
    )
    ?>

    <?= $this->render(
        'content.php',
        ['content' => $content]
    ) ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
