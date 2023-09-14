<?php

namespace Tests\Feature\Controllers\Supply\Categories;

use App\Enum\BaseinfoTypesEnum;
use App\Http\Controllers\Supply\Categories\StoreCategoryController;
use App\Http\Requests\Supply\Categories\StoreCategoryRequest;
use App\Models\Baseinfo;
use App\Models\Supply\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

class StoreCategoryControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_store_category_grand_parent_successfully_when_category_title_is_not_main_name()
    {
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

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
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
            'message' => __('messages.store', ['title' => __('title.category')]),
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
    public function authenticated_user_can_store_category_child_successfully_when_category_title_is_not_main_name()
    {
        $categoryParent = Category::factory()->create();
        $code = '02';
        $title = 'category';
        $discipline = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::DISCIPLINE->value,
            'value' => 'General'
        ]);
        $unit = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::UNIT_MEASURE->value,
            'value' => 'Meter'
        ]);

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'code' => $code,
            'title' => $title,
            'parent_id' => $categoryParent->id,
            'discipline' => $discipline->id,
            'unit' => $unit->id,
            'parent_id' => $categoryParent->id,
            'is_main_name' => 0
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.store', ['title' => __('title.category')]),
        ]);
        $this->assertDatabaseHas('categories', [
            'code' => $code,
            'category_title' => $title,
            'category_parent_id' => $categoryParent->id,
            'discipline_id' => $discipline->id,
            'unit_id' => $unit->id,
            'is_product' => 0
        ]);
    }

    /** @test */
    public function authenticated_user_can_store_category_child_successfully_when_category_title_not_main_name()
    {
        $categoryParent = Category::factory()->create();
        $code = '02';
        $title = 'category';
        $discipline = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::DISCIPLINE->value,
            'value' => 'General'
        ]);
        $unit = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::UNIT_MEASURE->value,
            'value' => 'Meter'
        ]);

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'code' => $code,
            'title' => $title,
            'parent_id' => $categoryParent->id,
            'discipline' => $discipline->id,
            'unit' => $unit->id,
            'parent_id' => $categoryParent->id,
            'is_main_name' => 1,
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.store', ['title' => __('title.category')]),
        ]);
        $this->assertDatabaseHas('categories', [
            'code' => $code,
            'category_title' => $title,
            'category_parent_id' => $categoryParent->id,
            'discipline_id' => $discipline->id,
            'unit_id' => $unit->id,
            'is_product' => 1
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_store_category()
    {
        $response = $this->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_store_category_when_user_has_not_permission()
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
    public function store_category_has_correct_validation_rules()
    {
        $this->assertEquals([
            'code' => ['required', 'unique:categories,code', 'string'],
            'title' => ['required', 'string', 'max:400'],
            'parent_id' => ['required'],
            'discipline' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::DISCIPLINE->value],
            'unit' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::UNIT_MEASURE->value],
            'is_main_name' => ['required', 'in:0,1']
        ], (new StoreCategoryRequest())->rules());
    }

    /** @test */
    public function store_category_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(StoreCategoryController::class, '__invoke', StoreCategoryRequest::class);
    }

    /** @test */
    public function authenticated_user_can_not_store_category_when_code_already_exists()
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

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
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
    public function authenticated_user_can_not_store_category_when_discipline_does_not_exists()
    {
        $code = '02';
        $title = 'category';
        $parentId = 0;
        $baseinfo = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::UNIT_MEASURE->value,
            'value' => 'Meter'
        ]);

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
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
    public function authenticated_user_can_not_store_category_when_unit_does_not_exists()
    {
        $code = '02';
        $title = 'category';
        $parentId = 0;
        $baseinfo = Baseinfo::factory()->create([
            'type' => BaseinfoTypesEnum::DISCIPLINE->value,
            'value' => 'General'
        ]);

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
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

    private function getRoute()
    {
        return route('supplies.v1.categories.store');
    }
}
