<?php

namespace app\controllers;

use app\models\Image;
use app\models\RequestData;
use app\models\Test;
use app\services\ImageService;
use app\services\MusicServices;
use app\services\SendMessageService;
use app\services\TestService;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Class HookController
 * @package app\controllers
 */
class HookController extends Controller
{
    private MusicServices $musicServices;
    private ImageService $imageService;
    private TestService $testService;
    private SendMessageService $sendMessageService;

    /**
     * @param $id
     * @param $module
     * @param MusicServices $musicServices
     * @param ImageService $imageService
     * @param TestService $testService
     * @param SendMessageService $sendMessageService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        MusicServices $musicServices,
        ImageService $imageService,
        TestService $testService,
        SendMessageService $sendMessageService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->musicServices = $musicServices;
        $this->imageService = $imageService;
        $this->testService = $testService;
        $this->sendMessageService = $sendMessageService;
    }

    /**
     * @param Action $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * @param array $requestDataArray
     */
    private function saveRequestData(array $requestDataArray): void
    {
        $requestData = new RequestData();

        $requestData->data_json = json_encode($requestDataArray);

        $requestData->save();
    }

    public function actionHook(): void
    {
        try {
            $requestData = json_decode(file_get_contents("php://input"), true);

            $chatId = $requestData['message']['chat']['id'];
            $messageText = $requestData['message']['text'];

            $this->saveRequestData($requestData);

            new Telegram(Yii::$app->params['token'], Yii::$app->params['botUsername']);

            $emptyKeyboard = ['remove_keyboard' => true];

            switch ($messageText) {
                case '/start':
                    $this->sendMessageService->sendText($chatId, 'Чтобы узнать все доступные команды, напиши /comands', $emptyKeyboard);
                    break;
                case '/comands':
                    $text = '<b>Доступные команды:</b>
/music - Подобрать музыку
/image - Получить изображение
/test - Пройти тест Роршаха';
                    $this->sendMessageService->sendText($chatId, $text, $emptyKeyboard, true);
                    break;
            }

            $imageImg = Image::findOne($messageText);

            switch ($messageText) {
                case '/image':
                    $this->sendMessageService->sendText($chatId, 'Чтобы получить изображение, введите его номер.');
                    $this->imageService->getImageName($chatId, $messageText, $emptyKeyboard);
                    break;
                case $imageImg->id:
                    $this->sendMessageService->sendImageFromDb(
                        $chatId,
                        $imageImg->img,
                        '<b>' . $imageImg->name . '</b>',
                        $emptyKeyboard,
                        true
                    );
                    break;
            }

            switch ($messageText){
                case '/music':
                    $keyboardMusic = [
                        "keyboard" => [
                            [
                                ["text" => "/rap"],
                                ["text" => "/rock"],
                                ["text" => "/pop"],
                            ]
                        ],
                        "one_time_keyboard" => true,
                        "resize_keyboard" => true
                    ];
                    $this->sendMessageService->sendText($chatId, 'Выберите ваш любимый жанр музыки:', $keyboardMusic);
                    break;
                case '/rap':
                case '/rock':
                case '/pop':
                    $this->musicServices->getMusicStyle($chatId, $messageText, $emptyKeyboard);
                    break;
            }

            //Test
            switch ($messageText){
                case '/бабочка':
                case '/маска':
                case '/другое':
                case '/птица':
                case '/крик':
                case '/несхожий':
                case '/жук':
                case '/дракон':
                case '/пропуск':
                    $this->testService->saveAnswer($chatId, $messageText);
                    break;
            }

            switch ($messageText){
                case '/test':
                    $post = new Test();

                    $post->chat = $chatId;
                    $post->save();

                    $this->sendMessageService->sendText(
                        $chatId,
                        '<b>Тест Роршаха.</b> 
Ниже будут представлены изображения и ответы к ним. Исходя из твоих ответов мы узнаем о твоем психотипе. 
<b>Если захотите выйти из теста, введите команду:</b> /exit',
                        $emptyKeyboard,
                        true
                    );
                    $keyboard = [
                        'keyboard' => [
                            [
                                ['text' => '/бабочка'],
                                ['text' => '/маска'],
                                ['text' => '/другое'],
                            ],
                        ],
                        'one_time_keyboard' => true,
                        'resize_keyboard' => true,
                    ];
                    $this->sendMessageService->sendImageFromUrl(
                        $chatId,
                        'https://upload.wikimedia.org/wikipedia/commons/thumb/1/13/Inkblot.svg/1200px-Inkblot.svg.png',
                        'Что ты видишь на этом изображении?',
                        $keyboard,
                    );
                    break;
                case '/exit':
                    $deleteTest = Test::find()->where(['chat' => $chatId])->one();
                    $deleteTest->delete();
                    $this->sendMessageService->sendText(
                        $chatId,
                        '<b>Доступные команды:</b>
/music - Подобрать музыку
/image - Получить изображение
/test - Пройти тест Роршаха',
                        $emptyKeyboard,
                        true
                    );
                    break;
                case '/бабочка':
                case '/маска':
                case '/другое':
                    $keyboard = [
                        "keyboard" => [
                            [
                                ["text" => "/птица"],
                                ["text" => "/крик",],
                                ["text" => "/несхожий"]
                            ]
                        ],
                        "one_time_keyboard" => true,
                        "resize_keyboard" => true,
                    ];
                    $this->sendMessageService->sendImageFromUrl(
                        $chatId,
                        'https://avatars.mds.yandex.net/get-zen_doc/3892121/pub_5f61e0bdfab9c9133cdfe115_5f61e404fab9c9133ce71098/scale_1200',
                        'Отлично! Продолжим.',
                        $keyboard,
                    );
                    break;
                case '/птица':
                case '/крик':
                case '/несхожий':
                    $keyboard = [
                        "keyboard" => [
                            [
                                ["text" => "/жук"],
                                ["text" => "/дракон"],
                                ["text" => "/пропуск",],
                            ],
                        ],
                        "one_time_keyboard" => true,
                        "resize_keyboard" => true
                    ];
                    $this->sendMessageService->sendImageFromUrl(
                        $chatId,
                        'https://static.life.ru/posts/2017/02/974190/5d96129307be2a02a6fb4ccd796e25f0.jpg',
                        'И последнее.',
                        $keyboard,
                    );
                    break;
                case '/жук':
                case '/дракон':
                case '/пропуск':
                $this->testService->getTestResult($chatId, $messageText, $emptyKeyboard);
                break;
            }
        } catch (\Throwable $e) {
            Yii::error([
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
