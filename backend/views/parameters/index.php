<?php

use common\models\Parameters;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use Yii;

/** @var yii\web\View $this */
/** @var common\models\ParametersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Parameters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parameters-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Parameters', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

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
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Parameters $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],

        ],
    ]); ?>


</div>
