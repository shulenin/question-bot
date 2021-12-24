<?php

namespace app\controllers;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Yii;
use yii\web\Controller;

class SetController extends Controller
{
    public function actionSetTelegram()
    {
        try {

            $telegram = new Telegram(Yii::$app->params['token'], Yii::$app->params['botUsername']);

            $result = $telegram->setWebhook(Yii::$app->params['url']);

            if ($result->isOk()) {
                echo $result->getDescription();
            }

        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }
}
