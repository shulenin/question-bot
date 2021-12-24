<?php

namespace app\services;

use Longman\TelegramBot\Request;

class SendMessageService
{
    public function sendText(int $chatId, string $text, array $keyboard = [], bool $isHtml = false)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        if (!empty($keyboard)) {
            $data['reply_markup'] = json_encode($keyboard);
        }

        if ($isHtml) {
            $data['parse_mode'] = 'html';
        }

        $result = Request::sendMessage($data);
    }

    public function sendImageFromDb(int $chatId, string $photo, string $caption, array $keyboard, bool $isHtml = false)
    {
        $data = [
            'chat_id' => $chatId,
            'photo' => Request::encodeFile('uploads/' . $photo),
            'caption' => $caption,
        ];

        if ($isHtml) {
            $data['parse_mode'] = 'html';
        }

        $result = Request::sendPhoto($data);
    }

    public function sendImageFromUrl(int $chatId, string $photo, string $caption, array $keyboard, bool $isHtml = false)
    {
        $data = [
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
        ];

        if (!empty($keyboard)) {
            $data['reply_markup'] = json_encode($keyboard);
        }

        if ($isHtml) {
            $data['parse_mode'] = 'html';
        }

        $result = Request::sendPhoto($data);
    }
}
