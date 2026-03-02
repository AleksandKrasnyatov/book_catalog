<?php

declare(strict_types=1);

namespace app\helpers;

use Exception;
use Yii;

class FileHelper
{
    /**
     * @throws Exception
     */
    public static function getPhotosDirPath(): string
    {
        $photosDir = Yii::getAlias('@webroot/photos');
        if (!is_dir($photosDir) && !mkdir($photosDir, 0775, true) && !is_dir($photosDir)) {
            throw new Exception('Не удалось создать директорию для фото');
        }
        return $photosDir;
    }
}
