<?php
namespace frontend\controllers;

use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use common\models\Parameters;
use yii\web\Response;
use Yii;

class ParametersController extends Controller
{

    public function actionIndex() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $params = Parameters::find()->with('images')->all();

        $result = [];
        foreach ($params as $param) {
            $result[] = array_merge($param->toArray(), [
                'images' => $param->images
            ]);
        }
        return $result;
    }
}
