<?php

namespace app\components;

use app\controllers\SiteController;
use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\web\Response;

class ResponseFormatter extends Behavior
{
    public function events()
    {
        return [
            Response::EVENT_BEFORE_SEND => 'formatResponse',
        ];
    }
    
    /**
     * @param Event $event
     */
    public function formatResponse(Event $event)
    {
        
        if (Yii::$app->requestedAction->controller instanceof SiteController) {
            return;
        }
        
        /** @var Response $response */
        $response = $event->sender;
        
        $response->format = Response::FORMAT_JSON;
        
        if ($response->data) {
            $response->data = [
                'code' => $response->isSuccessful ? 0 : $response->statusCode,
                'message' => $response->statusText,
                'data' => $response->data,
            ];
        } else {
            $response->data = [
                'code' => $response->isSuccessful ? 0 : $response->statusCode,
                'message' => $response->statusText,
            ];
        }
        
        $response->statusCode = 200;
    }
}
