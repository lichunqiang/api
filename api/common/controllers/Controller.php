<?php

namespace app\api\common\controllers;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\rest\Controller as BaseController;
use yii\rest\OptionsAction;
use yii\web\Response;

/**
 * Basic controller of all the rest controller.
 */
abstract class Controller extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
            'authenticator' => [
                'class' => CompositeAuth::className(),
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ]
        ];
    }
    
    /**
     * Send validation faild response
     *
     * @param  string $msg
     *
     * @return Response
     */
    public function sendFaildValidation($msg)
    {
        return Yii::$app->response->setStatusCode(422, $msg);
    }
    
    /**
     * Send error response
     *
     * @param string $msg
     *
     * @return Response
     */
    public function error($msg)
    {
        return Yii::$app->response->setStatusCode(500, $msg);
    }
}
