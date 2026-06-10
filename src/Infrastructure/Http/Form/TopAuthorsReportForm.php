<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Form;

use yii\base\Model;

final class TopAuthorsReportForm extends Model
{
    public ?int $year = null;

    public function rules(): array
    {
        return [
            ['year', 'required'],
            ['year', 'integer', 'min' => 1000, 'max' => (int) date('Y')],
        ];
    }

    public function afterValidate(): void
    {
        if ($this->year === null) {
            $this->year = (int) date('Y');
        }

        parent::afterValidate();
    }
}
