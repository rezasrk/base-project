<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Models\Baseinfo;
use App\Models\Supply\Category;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class ShowCategoryControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_a_category()
    {
        $discipline = Baseinfo::factory()->create();
        $unit = Baseinfo::factory()->create();
        $category = Category::factory()->create([
            'discipline_id' => $discipline->id,
            'unit_id' => $unit->id,
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute($category->id));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.category')]),
            'data' => [
                'id' => $category->id,
                'title' => $category->category_title,
                'code' => $category->code,
                'discipline' => [
                    'id' => $discipline->id,
                    'value' => $discipline->value
                ],
                'unit' => [
                    'id' => $unit->id,
                    'value' => $unit->value
                ]
            ]
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_a_category()
    {
        $response = $this->getJson($this->getRoute(1243));

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_a_category_when_category_does_not_exists()
    {
        $response = $this->actingAsSuperUser()->getJson($this->getRoute(23435232324434));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
    }

    private function getRoute($categoryId)
    {
        return route('supplies.v1.categories.show', $categoryId);
    }
}
