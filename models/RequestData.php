<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class RequestData
 * @package app\models
 *
 * @property string $data_json
 */
class RequestData extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'request_data';
    }
}