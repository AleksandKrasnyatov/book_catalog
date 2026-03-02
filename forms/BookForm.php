<?php

namespace app\forms;

use app\dto\BookDto;
use app\helpers\FileHelper;
use app\models\Book;
use app\models\BookAuthor;
use Exception;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

class BookForm extends Model
{
    public $title;
    public $year;
    public $description;
    public $isbn;
    public $photo;
    public $photoFile;
    public $authorIds = [];

    public function __construct(?Book $book = null, $config = [])
    {
        if ($book) {
            $this->title = $book->title;
            $this->year = $book->year;
            $this->description = $book->description;
            $this->isbn = $book->isbn;
            $this->photo = $book->photo;
            $this->authorIds = array_column($book->bookAuthors, 'author_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'year'], 'required'],
            [['description'], 'string'],
            [['year'], 'integer', 'max' => date('Y')],
            [['title', 'isbn', 'photo'], 'string', 'max' => 255],
            ['photoFile', 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'webp']],
            ['authorIds', 'each', 'rule' => ['integer']],
            ['authorIds', 'required'],
        ];
    }

    public function beforeValidate(): bool
    {
        $this->photoFile = UploadedFile::getInstance($this, 'photoFile');
        return parent::beforeValidate();
    }

    public function toDto(): BookDto
    {
        return new BookDto(
            $this->title,
            $this->year,
            $this->description,
            $this->isbn,
            $this->photo
        );
    }

    /**
     * @throws Exception
     */
    public function applyPhotoUpload(): void
    {
        if (!$this->photoFile instanceof UploadedFile) {
            return;
        }

        $photosDir = FileHelper::getPhotosDirPath();
        $fileName = Yii::$app->security->generateRandomString(16) . '.' . $this->photoFile->extension;
        $path = "{$photosDir}/{$fileName}";
        if (!$this->photoFile->saveAs($path)) {
            throw new Exception('Не удалось сохранить файл фотографии');
        }

        $this->photo = $fileName;
    }
}
