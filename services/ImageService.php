<?php

namespace app\services;

use app\models\Image;

class ImageService
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

    public function getImageName($chatId, $messageText, $keyboard)
    {
        $images = Image::find()->all();

        switch ($messageText) {
            case '/image':
                foreach ($images as $image) {
                    $this->sendMessageService->sendText(
                        $chatId,
                        '<b>' . $image->id . '</b>: ' . $image->name,
                        $keyboard,
                        true
                    );
                }
                break;
        }
    }
}
