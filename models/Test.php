<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Test
 * @package app\models
 */
class Test extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'test';
    }
}
