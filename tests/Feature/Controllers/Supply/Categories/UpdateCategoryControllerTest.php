<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Enum\BaseinfoTypesEnum;
use App\Http\Controllers\Supply\Categories\UpdateCategoryController;
use App\Http\Requests\Supply\Categories\UpdateCategoryRequest;
use App\Models\Baseinfo;
use App\Models\Supply\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class UpdateCategoryControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_update_category_successfully()
    {
        $category = Category::factory()->create();
        $code = '02';
        $title = 'category';
        $parentId = 0;
        $discipline = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::DISCIPLINE->value,
            'value' => 'General'
        ]);
        $unit = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::UNIT_MEASURE->value,
            'value' => 'Meter'
        ]);

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($category->id), [
            'code' => $code,
            'title' => $title,
            'parent_id' => $parentId,
            'discipline' => $discipline->id,
            'unit' => $unit->id,
            'is_main_name' => 0
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.category')]),
        ]);
        $this->assertDatabaseHas('categories', [
            'code' => $code,
            'category_title' => $title,
            'category_parent_id' => $parentId,
            'discipline_id' => $discipline->id,
            'unit_id' => $unit->id,
            'is_product' => 0
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_update_category()
    {
        $response = $this->putJson($this->getRoute(1234));

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_category_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->putJson($this->getRoute(345));

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    /** @test */
    public function update_category_has_correct_validation_rules()
    {
        $categoryId = 456;
        $request = new UpdateCategoryRequest();
        $request->setRouteResolver(function () use ($categoryId) {
            $route = new Route('put', $this->getRoute($categoryId), [UpdateProjectController::class]);
            $route->parameters['id'] = $categoryId;

            return $route;
        });

        $this->assertEquals([
            'code' => ['required', 'unique:categories,code,' . $categoryId . ',id', 'string'],
            'title' => ['required', 'string', 'max:400'],
            'parent_id' => ['required'],
            'discipline' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::DISCIPLINE->value],
            'unit' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::UNIT_MEASURE->value],
            'is_main_name' => ['required', 'in:0,1']
        ], $request->rules());
    }

    /** @test */
    public function update_category_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(UpdateCategoryController::class, '__invoke', UpdateCategoryRequest::class);
    }

    /** @test */
    public function authenticated_user_can_not_update_request_when_code_already_exists()
    {
        $code = '02';
        $title = 'category';
        $parentId = 0;
        Category::factory()->create([
            'code' => $code
        ]);
        $discipline = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::DISCIPLINE->value,
            'value' => 'General'
        ]);
        $unit = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::UNIT_MEASURE->value,
            'value' => 'Meter'
        ]);
        $category = Category::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($category->id), [
            'code' => $code,
            'title' => $title,
            'parent_id' => $parentId,
            'discipline' => $discipline->id,
            'unit' => $unit->id,
            'is_main_name' => 0
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'code' => [
                    __('validation.unique', ['attribute' => 'code']),
                ],
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_request_when_discipline_does_not_exists()
    {
        $code = '02';
        $title = 'category';
        $parentId = 0;
        $baseinfo = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::UNIT_MEASURE->value,
            'value' => 'Meter'
        ]);
        $category = Category::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($category->id), [
            'code' => $code,
            'title' => $title,
            'parent_id' => $parentId,
            'discipline' => $baseinfo->id,
            'unit' => $baseinfo->id,
            'is_main_name' => 0
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'discipline' => [
                    __('validation.exists', ['attribute' => 'discipline']),
                ],
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_request_when_unit_does_not_exists()
    {
        $code = '02';
        $title = 'category';
        $parentId = 0;
        $baseinfo = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::DISCIPLINE->value,
            'value' => 'General'
        ]);
        $category = Category::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($category->id), [
            'code' => $code,
            'title' => $title,
            'parent_id' => $parentId,
            'discipline' => $baseinfo->id,
            'unit' => $baseinfo->id,
            'is_main_name' => 0
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'unit' => [
                    __('validation.exists', ['attribute' => 'unit']),
                ],
            ],
        ]);
    }

    private function getRoute(int $categoryId)
    {
        return route('supplies.v1.categories.update', $categoryId);
    }
}
