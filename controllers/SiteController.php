<?php

namespace app\controllers;

use light\swagger\SwaggerAction;
use light\swagger\SwaggerApiAction;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class SiteController extends Controller
{
    public $defaultAction = 'doc';
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'doc' => [
                'class' => SwaggerAction::class,
                'restUrl' => Url::to(['/site/api'], true),
            ],
            //The resultUrl action.
            'api' => [
                'class' => SwaggerApiAction::class,
                //The scan directories, you should use real path there.
                'scanDir' => [
                    Yii::getAlias('@app/swagger/v1'),
                    Yii::getAlias('@app/api/v1/controllers'),
                ],
                //The security key
                'api_key' => 'yii2good',
                'apiKeyParam' => 'api-key',
            ],
        ];
    }
}
