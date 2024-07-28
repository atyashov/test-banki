<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Parameters $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Parameters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parameters-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'type',
            [
                'label' => 'Images',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->images) {
                        $result = '';
                        foreach ($model->images as $image) {
                            $result .= Html::img(Yii::$app->request->baseUrl . '/img/' . $image->server_name, [
                                'style' => 'width: 150px',
                                'class' => 'm-2',
                                'alt' => $image->name
                            ]);
                        }
                    } else $result = 'No images';
                    return $result;
                }
            ],
        ],
    ]) ?>

</div>
