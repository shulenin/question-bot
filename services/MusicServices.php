<?php

namespace app\services;

class MusicServices
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

    public function getMusicStyle($chatId, $messageText, $keyboard)
    {
        switch ($messageText){
            case '/rap':
                $this->sendMessageService->sendImageFromUrl(
                    $chatId,
                    'https://www.zastavki.com/pictures/1024x768/2012/Music_Eminem_2012_034897_1.jpg',
                    '<b>ТОП реп-исполнителей:</b>
1 место
2 место
3 место',

                    $keyboard,
                    true,
                );
                break;
            case '/pop':
                $this->sendMessageService->sendImageFromUrl(
                    $chatId,
                    'https://o-mostovskom.su/wp-content/uploads/2019/05/Rok-1024x653.jpg.pagespeed.ce.QUOk1lrKSc.jpg',
                    '<b>ТОП рок-исполнителей:</b>
1 место
2 место
3 место',

                    [],
                    true,
                );
                break;
            case '/rock':
                $this->sendMessageService->sendImageFromUrl(
                    $chatId,
                    'https://gazetadaily.ru/wp-content/uploads/2019/01/pop-muzyka-558-768x684.jpg',
                    '<b>ТОП поп-исполнителей:</b>
1 место
2 место
3 место',

                    $keyboard,
                    true,
                );
                break;
        }
    }
}
