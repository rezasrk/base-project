<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Models\Supply\Category;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class ShowCategoryRankControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_get_category_rank_successfully()
    {
        $parentCategory = Category::factory()->create();
        $childCategory = Category::factory()->create([
            'category_parent_id' => $parentCategory->id
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute($childCategory->id));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.category')]),
            'data' => [
                $childCategory->id,
                $parentCategory->id,
            ]
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_get_last_category_rank_when_limit_is_over()
    {
        $first = Category::factory()->create();
        $second = Category::factory()->create([
            'category_parent_id' => $first->id
        ]);
        $third = Category::factory()->create([
            'category_parent_id' => $second->id
        ]);
        $fourth = Category::factory()->create([
            'category_parent_id' => $third->id
        ]);
        $fifth = Category::factory()->create([
            'category_parent_id' => $fourth->id
        ]);
        $sixth = Category::factory()->create([
            'category_parent_id' => $fifth->id
        ]);
        $seventh = Category::factory()->create([
            'category_parent_id' => $sixth->id
        ]);
        $eight = Category::factory()->create([
            'category_parent_id' => $seventh->id
        ]);
        $ninth = Category::factory()->create([
            'category_parent_id' => $eight->id
        ]);
        $tenth = Category::factory()->create([
            'category_parent_id' => $ninth->id
        ]);
        $eleventh = Category::factory()->create([
            'category_parent_id' => $tenth->id
        ]);
        Category::factory()->create([
            'category_parent_id' => $eleventh->id
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute($eleventh->id));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.category')]),
            'data' => [
                $eleventh->id,
                $tenth->id,
                $ninth->id,
                $eight->id,
                $seventh->id,
                $sixth->id,
                $fifth->id,
                $fourth->id,
                $third->id,
                $second->id,
                $first->id
            ]
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_get_category_rank()
    {
        $response = $this->getJson($this->getRoute(124));

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_get_category_rank_when_category_id_is_not_exists()
    {
        $response = $this->actingAsSuperUser()->getJson($this->getRoute(1250000));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
    }

    private function getRoute(int $id)
    {
        return route('supplies.v1.categories.rank', $id);
    }
}
