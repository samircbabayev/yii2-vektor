<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductImg */

$this->title = 'Create Product Img';
$this->params['breadcrumbs'][] = ['label' => 'Product Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-img-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
