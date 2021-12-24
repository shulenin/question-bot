<?php

namespace app\services;

use app\models\Test;
use yii\db\Query;

class TestService
{
    private SendMessageService $sendMessageService;

    /**
     * @param SendMessageService $sendMessageService
     */
    public function __construct(
        SendMessageService $sendMessageService
    ) {
        $this->sendMessageService = $sendMessageService;
    }

    /**
     * @param $chatId
     * @param $messageText
     */
    public function saveAnswer($chatId, $messageText)
    {
        $test = Test::find()->where(['chat' => $chatId])->one();

        switch ($messageText){
            case '/бабочка':
            case '/маска':
            case '/другое':
            $test->answer_1 = $messageText;
            $test->save();
                break;
            case '/птица':
            case '/крик':
            case '/несхожий':
            $test->answer_2 = $messageText;
            $test->save();
                break;
            case '/жук':
            case '/дракон':
            case '/пропуск':
            $test->answer_3 = $messageText;
            $test->save();
                break;
        }
    }

    /**
     * @param $chatId
     * @param $messageText
     */
    public function getTestResult($chatId, $messageText, $keyboard)
    {
        $test = Test::find()->where(['chat' => $chatId])->one();

        switch ($test->answer_1) {
            case '/бабочка':
                $firstResult = 'Бабочка';
                $firstAnswer = 'Вы открыты с людьми и готовы помогать им безвозмездно.';
                break;
            case '/маска':
                $firstResult = 'Маска';
                $firstAnswer = 'Вы очень цените личное пространство и тщательно проверяете его порядок.';
                break;
            case '/другое':
                $firstResult = 'Другое';
                $firstAnswer = 'Вы чувствуете собственную потеряность среди социума и нет ощущения комфорта.';
                break;
        }

        switch ($test->answer_2) {
            case '/птица':
                $secondResult = 'Птица';
                $secondAnswer = 'Вы цените свободу.';
                break;
            case '/крик':
                $secondResult = 'Крик';
                $secondAnswer = 'В вашей душа осталась душевная рана, нанесенная в давнем прошлом.';
                break;
            case '/несхожий':
                $secondResult = 'Несхожий';
                $secondAnswer = 'Вы чувствуете, что отличаетесь от большинства людей.';
                break;
        }
        switch ($test->answer_3) {
            case '/жук':
                $thirdResult = 'Жук';
                $thirdAnswer = 'Вы цените в людях честность и верность.';
                break;
            case '/дракон':
                $thirdResult = 'Дракон';
                $thirdAnswer = 'У вас сложный характер, но это не мешает вам коммуницировать с другими людьми.';
                break;
            case '/пропуск':
                $thirdResult = 'Пропуск';
                $thirdAnswer = 'Вы чувствуете отчужденность.';
                break;

        }
        switch ($messageText){
            case '/жук':
            case '/дракон':
            case '/пропуск':
            $this->sendMessageService->sendText(
                $chatId,
                '<b>Поздравляю с выполнением теста!</b>

<i>Ваши результаты:</i>
<b>'. $firstResult .'</b>: ' . $firstAnswer . '
<b>'. $secondResult .'</b>: ' . $secondAnswer . '
<b>'. $thirdResult .'</b>: ' . $thirdAnswer . '

Для более углубленного результата рекомендуем пройти  <a href="https://testometrika.com/personality-and-temper/rorschach-test/">полный тест на нашем сайте.</a>',
                $keyboard,
                true,
            );
                break;
        }
    }
}