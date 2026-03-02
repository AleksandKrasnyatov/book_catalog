<?php

declare(strict_types=1);

namespace app\models;

use app\dto\BookDto;
use app\helpers\FileHelper;
use Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $photo
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-read BookAuthor[] $bookAuthors
 * @property-read Author[] $authors
 */
class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%books}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    public static function create(BookDto $dto): self
    {
        $model = new self();
        $model->edit($dto);
        return $model;
    }

    public function edit(BookDto $dto): void
    {
        $this->title = $dto->title;
        $this->year = $dto->year;
        $this->description = $dto->description;
        $this->isbn = $dto->isbn;
        $this->photo = $dto->photo;
    }

    /**
     * @throws Exception
     */
    public function getPhotoUrl(bool $web = true): ?string
    {
        if (!$this->photo) {
            return null;
        }
        $photosDir = FileHelper::getPhotosDirPath();
        $path = "{$photosDir}/{$this->photo}";
        if (!file_exists($path)) {
            return null;
        }
        if ($web) {
            return substr($path, strpos($path, 'web') + 3);
        }
        return $path;
    }

    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('bookAuthors');
    }
}
