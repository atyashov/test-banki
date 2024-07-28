<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Parameters $model */

$this->title = 'Create Parameters';
$this->params['breadcrumbs'][] = ['label' => 'Parameters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parameters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
