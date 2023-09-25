<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Models\Baseinfo;
use App\Models\Supply\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class IndexCategoryControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_categories_list()
    {
        $discipline = Baseinfo::factory()->create();
        $unit = Baseinfo::factory()->create();
        $category = Category::factory()->create([
            'discipline_id' => $discipline->id,
            'unit_id' => $unit->id,
            'category_parent_id' => 0,
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.category')]),
            'data' => [
                [
                    'id' => $category->id,
                    'title' => $category->category_title,
                    'code' => $category->code,
                    'discipline' => [
                        'id' => $discipline->id,
                        'value' => $discipline->value,
                    ],
                    'unit' => [
                        'id' => $unit->id,
                        'value' => $unit->value,
                    ],
                ],
            ],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 300,
                'total' => 1,
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_categories_list()
    {
        $response = $this->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_categories_list_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    private function getRoute()
    {
        return route('supplies.v1.categories.index');
    }
}
