<?php

namespace App\Http\Requests\Supply\Categories;

use App\Http\Requests\BaseFormRequest;

class TransferCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'category_parent_id' => ['required', 'exists:categories,id'],
            'category_id' => ['required', 'exists:categories,id']
        ];
    }

    public function bodyParameters()
    {
        return [
            'category_parent_id' => [
                'description' => 'ID of parent category',
                'category_parent_id' => 23
            ],
            'category_id' => [
                'description' => 'ID of category',
                'category_parent_id' => 14
            ]
        ];
    }
}
