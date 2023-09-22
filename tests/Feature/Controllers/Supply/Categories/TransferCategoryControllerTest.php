<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Http\Controllers\Supply\Categories\TransferCategoryController;
use App\Http\Requests\Supply\Categories\TransferCategoryRequest;
use App\Models\Supply\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class TransferCategoryControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_transfer_category_successfully()
    {
        $oldCategoryParent = Category::factory()->create();
        $newCategoryParent = Category::factory()->create();
        $category = Category::factory()->create([
            'category_parent_id' => $oldCategoryParent->id,
        ]);

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'category_parent_id' => $newCategoryParent->id,
            'category_id' => $category->id,
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.category')]),
        ]);
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'category_parent_id' => $newCategoryParent->id,
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_transfer_category_when_category_parent_id_does_not_exists()
    {
        $oldCategoryParent = Category::factory()->create();
        $category = Category::factory()->create([
            'category_parent_id' => $oldCategoryParent->id,
        ]);

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'category_parent_id' => 962222222544555,
            'category_id' => $category->id,
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'category_parent_id' => [
                    __('validation.exists', ['attribute' => 'category parent id']),
                ],
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_transfer_category_when_category_id_does_not_exists()
    {
        $oldCategoryParent = Category::factory()->create();

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'category_parent_id' => $oldCategoryParent->id,
            'category_id' => 6587458666665445,
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'category_id' => [
                    __('validation.exists', ['attribute' => 'category id']),
                ],
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_transfer_category()
    {
        $response = $this->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_transfer_category_when_user_has_not_permission()
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
    public function transfer_category_has_correct_validation_rules()
    {
        $this->assertEquals([
            'category_parent_id' => ['required', 'exists:categories,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ], (new TransferCategoryRequest())->rules());
    }

    /** @test */
    public function transfer_category_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(TransferCategoryController::class, '__invoke', TransferCategoryRequest::class);
    }

    private function getRoute()
    {
        return route('supplies.v1.categories.transfer');
    }
}
