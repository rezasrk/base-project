<?php

namespace App\Http\Requests\Supply\Categories;

use App\Http\Requests\BaseFormRequest;

/**
 *@bodyParam data object[] required List of things to do
 *@bodyParam data[].category_id int Example: 12
 *@bodyParam data[].priority int Example: 100
 */
class SortCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'data' => ['present', 'array', 'min:1'],
            'data.*.category_id' => ['required', 'exists:categories,id'],
            'data.*.priority' => ['required', 'int']
        ];
    }
}
