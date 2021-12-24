<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * Class Image
 * @package app\models
 * @property $id
 * @property $name
 * @property $img
 */
class Image extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'image';
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Add name',
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['name', 'required', 'message' => 'Поле обязательно'],
            [['eventImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return self::find()->all();
    }
}
