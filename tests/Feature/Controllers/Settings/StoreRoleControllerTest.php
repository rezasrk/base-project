<?php

namespace Tests\Feature\Controllers\Settings;

use App\Http\Controllers\Settings\StoreRoleController;
use App\Http\Requests\Settings\StoreRoleRequest;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class StoreRoleControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_store_roles_successfully()
    {
        $name = 'role';
        $status = 1;
        $permission = Permission::factory()->create([
            'name' => 'write article',
        ]);
        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'name' => $name,
            'permissions' => [$permission->id],
            'status' => $status
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.store', ['title' => __('title.role')]),
        ]);
        $this->assertDatabaseHas('roles', [
            'name' => $name,
            'guard_name' => 'sanctum',
            'status' => $status
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_store_roles()
    {
        $response = $this->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function store_roles_has_correct_validation_rules()
    {
        $this->assertEquals([
            'name' => ['required', 'unique:roles,name'],
            'permissions' => ['present', 'array'],
            'status' => ['required', 'in:1,0'],
            'permissions.*' => ['required'],
        ], (new StoreRoleRequest())->rules());
    }

    /** @test */
    public function store_roles_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(StoreRoleController::class, '__invoke', StoreRoleRequest::class);
    }

    /** @test */
    public function authenticated_user_can_not_store_roles_when_user_does_not_access()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    private function getRoute()
    {
        return route('settings.role.store');
    }
}
