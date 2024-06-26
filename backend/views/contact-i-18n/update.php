<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContactI18n */

$this->title = 'Yenilə, Əlaqə ' . \Yii::$app->request->get('lang');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact I18ns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contact-i18n-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>