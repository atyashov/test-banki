<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Parameters;
use common\models\Images;
use Yii;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Parameters $model */
/** @var yii\widgets\ActiveForm $form */

if ($model->images) {
    $imageTypeOne = $model->getTypedImage(Images::TYPEONE);
    $imageTypeTwo = $model->getTypedImage(Images::TYPETWO);
}

?>

<div class="parameters-form">

    <div class="container-fluid">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">

            <div class="col-md-3">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'type')->dropDownList([
                    Parameters::TYPEONE => 'Type One',
                    Parameters::TYPETWO => 'Type Two'
                ]) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'upload_icon')->fileInput() ?>

                <?= isset($imageTypeOne) ?
                    Html::img(Yii::$app->request->baseUrl . '/img/' . $imageTypeOne->server_name, [
                        'style' => 'max-width: 250px',
                        'alt' => $imageTypeOne->name,
                        'class' => 'm-2'
                ]) . Html::a('<i class="fa fa-times"></i>',
                        Url::to([
                            '/parameters/delete-image',
                            'id' => $imageTypeOne->id
                        ]), [
                        'title' => 'Удалить изображение',
                        'class' => "btn btn-danger",
                        'data' => [
                            'confirm' => 'Удалить изображение ' . $imageTypeOne->name . '?',
                            'method' => 'post',
                            'pjax' => 0
                        ],
                ])  : null ?>
            </div>

            <div class="col-md-3">
                <?php if (!$model->isNewRecord && $model->type == Parameters::TYPETWO) : ?>
                    <?= $form->field($model, 'upload_icon_grey')->fileInput() ?>
                    <?= isset($imageTypeTwo) ?
                        Html::img(Yii::$app->request->baseUrl . '/img/' . $imageTypeTwo->server_name, [
                            'style' => 'max-width: 250px',
                            'alt' => $imageTypeTwo->name,
                            'class' => 'm-2'
                        ]) . Html::a('<i class="fa fa-times"></i>', Url::to([
                                '/parameters/delete-image',
                                'id' => $imageTypeTwo->id
                        ]), [
                            'title' => 'Удалить изображение',
                            'class' => "btn btn-danger",
                            'data' => [
                                'confirm' => 'Удалить изображение ' . $imageTypeTwo->name . '?',
                                'method' => 'post',
                                'pjax' => 0
                            ],
                        ]) : null ?>
                <?php endif; ?>
            </div>

        </div>

        <div class="form-group mt-2">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

            <?php ActiveForm::end(); ?>
    </div>

</div>
