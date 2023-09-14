<?php

namespace App\Http\Requests\Supply\Categories;

use App\Enum\BaseinfoTypesEnum;
use App\Http\Requests\BaseFormRequest;

class StoreCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'code' => ['required', 'unique:categories,code', 'string'],
            'title' => ['required', 'string', 'max:400'],
            'parent_id' => ['required'],
            'discipline' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::DISCIPLINE->value],
            'unit' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::UNIT_MEASURE->value],
            'is_main_name' => ['required', 'in:0,1']
        ];
    }

    public function bodyParameters()
    {
        return [
            'code' => [
                'description' => 'The code of category',
                'example' => '01'
            ],
            'title' => [
                'description' => 'The title of category',
                'example' => 'Title'
            ],
            'parent_id' => [
                'description' => 'The parent id of category',
                'example' => 1,
            ],
            'discipline' => [
                'description' => 'The discipline of category',
                'example' => 35
            ],
            'unit' => [
                'description' => 'The unit of category',
                'example' => 96
            ],
            'is_main_name' => [
                'description' => 'Is the main name',
                'example' => '1 Or 0'
            ]
        ];
    }
}
