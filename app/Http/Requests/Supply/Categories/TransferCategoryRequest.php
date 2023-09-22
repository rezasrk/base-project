<?php

namespace App\Http\Requests\Supply\Categories;

use App\Http\Requests\BaseFormRequest;

class TransferCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'category_parent_id' => ['required', 'exists:categories,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'category_parent_id' => [
                'description' => 'ID of parent category',
                'example' => 23,
            ],
            'category_id' => [
                'description' => 'ID of category',
                'example' => 14,
            ],
        ];
    }
}
