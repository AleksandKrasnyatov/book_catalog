<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use yii\base\Model;
use yii\web\UploadedFile;

final class BookForm extends Model
{
    public ?string $title = null;
    public ?int $year = null;
    public ?string $description = null;
    public ?string $isbn = null;
    public null|string|UploadedFile $photoFile = null;
    public bool $removePhoto = false;
    public array $authorIds = [];

    public function rules(): array
    {
        return [
            [['title', 'year'], 'required'],
            ['title', 'trim'],
            [['title', 'isbn'], 'string', 'max' => 255],
            ['description', 'string'],
            ['year', 'integer', 'min' => 1000, 'max' => (int) date('Y')],
            ['photoFile', 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'webp']],
            ['removePhoto', 'boolean'],
            ['authorIds', 'each', 'rule' => ['integer']],
            ['authorIds', 'required'],
        ];
    }

    public function beforeValidate(): bool
    {
        $this->photoFile = UploadedFile::getInstance($this, 'photoFile');

        return parent::beforeValidate();
    }
}

