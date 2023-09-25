<?php

namespace Tests\Unit\App\Services\General\Supply\Categories;

use App\Models\Supply\Category;
use App\Services\General\Supply\Categories\SearchCategory;
use Tests\RefreshDatabase;
use Tests\Unit\BaseUnitTestCase;

final class SearchCategoryTest extends BaseUnitTestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_category_can_get_categories_by_title_successfully()
    {
        $categoryTitle = 'category title';
        $grandCategory = Category::factory()->create();
        $parentCategory = Category::factory()->create(['category_parent_id' => $grandCategory->id]);
        $childCategory = Category::factory()->create([
            'category_parent_id' => $parentCategory->id,
            'category_title' => $categoryTitle
        ]);
        Category::factory()->create([
            'category_title' => 'alminium'
        ]);

        $result = $this->getSearchCategory()->byTitle($categoryTitle);

        $this->assertEquals([
            [
                'id' => $childCategory->id,
                'code'=>$childCategory->code,
                'full_title' => $grandCategory->category_title . ' - ' . $parentCategory->category_title . ' - ' . $childCategory->category_title,
                'title' => $childCategory->category_title,
            ]
        ], $result->getCategories());
        $this->assertEquals([
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 70,
                'total' => 1,
            ],
        ], $result->getPaginationInformation());
    }

    /** @test */
    public function search_category_can_not_get_categories_by_title_when_category_does_not_exists()
    {
        $categoryTitle = 'category title';
        $grandCategory = Category::factory()->create();
        $parentCategory = Category::factory()->create(['category_parent_id' => $grandCategory->id]);
        Category::factory()->create([
            'category_parent_id' => $parentCategory->id,
            'category_title' => $categoryTitle
        ]);

        $result = $this->getSearchCategory()->byTitle('empty');

        $this->assertEquals([], $result->getCategories());
        $this->assertEquals([
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 70,
                'total' => 0,
            ],
        ], $result->getPaginationInformation());
    }

    private function getSearchCategory()
    {
        return new SearchCategory;
    }
}
