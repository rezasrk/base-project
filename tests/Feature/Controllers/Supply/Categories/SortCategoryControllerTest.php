<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Http\Controllers\Supply\Categories\SortCategoryController;
use App\Http\Requests\Supply\Categories\SortCategoryRequest;
use App\Models\Supply\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class SortCategoryControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_sort_categories_successfully()
    {
        $categories = Category::factory()->times(1000)->create();
        $data = $categories->map(function ($item, $key) {
            return [
                'category_id' => $item->id,
                'priority' => $key
            ];
        })->all();

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'data' => $data
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.category')])
        ]);
        foreach ($data as $category) {
            $this->assertDatabaseHas('categories', [
                'id' => $category['category_id'],
                'priority' => $category['priority']
            ]);
        }
    }

    /** @test */
    public function unauthenticated_user_can_not_sort_categories()
    {
        $response = $this->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_sort_categories_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    /** @test */
    public function sort_category_have_correct_validation_rules()
    {
        $this->assertEquals([
            'data' => ['present', 'array', 'min:1'],
            'data.*.category_id' => ['required', 'exists:categories,id'],
            'data.*.priority' => ['required', 'int']
        ], (new SortCategoryRequest())->rules());
    }

    /** @test */
    public function sort_category_have_correct_form_request()
    {
        $this->assertActionUsesFormRequest(SortCategoryController::class, '__invoke', SortCategoryRequest::class);
    }

    private function getRoute()
    {
        return route('supplies.v1.categories.sort');
    }
}
