<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Models\Supply\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class SearchCategoryByNameControllerTest extends BaseFeatureTestCase
{
    use WithFaker;

    /** @test */
    public function authenticated_user_can_search_category_by_title_and_get_data_successfully()
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

        $response = $this->actingAsSuperUser()->getJson($this->getRoute() . '?title=' . $childCategory->category_title);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.category')]),
            'data' => [
                [
                    'id' => $childCategory->id,
                    'code' => $childCategory->code,
                    'title' => $childCategory->category_title,
                    'full_title' => $grandCategory->category_title . ' - ' . $parentCategory->category_title . ' - ' . $childCategory->category_title,
                ]
            ],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 70,
                'total' => 1,
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_search_category_by_title_and_get_data_in_the_page_number_two()
    {
        $categoryTitle = 'category title';
        $grandCategory = Category::factory()->create();
        $parentCategory = Category::factory()->create(['category_parent_id' => $grandCategory->id]);
        $childCategory = Category::factory()->create([
            'category_parent_id' => $parentCategory->id,
            'category_title' => $categoryTitle
        ]);
        Category::factory()->times(70)->create([
            'category_title' => $categoryTitle . ' ' . $this->faker()->name()
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute() . '?title=' . $childCategory->category_title . '&page=2');

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.category')]),
            'data' => [
                [
                    'id' => $childCategory->id,
                    'code' => $childCategory->code,
                    'title' => $childCategory->category_title,
                    'full_title' => $grandCategory->category_title . ' - ' . $parentCategory->category_title . ' - ' . $childCategory->category_title,
                ]
            ],
            'pagination' => [
                'current_page' => 2,
                'last_page' => 2,
                'per_page' => 70,
                'total' => 71,
            ],
        ]);
    }

    private function getRoute()
    {
        return route('supplies.v1.categories.search-by-title');
    }
}
