<?php

namespace Tests\Feature\Controllers\Settings;

use App\Enum\RoleEnum;
use App\Http\Controllers\Settings\Roles\UpdateRoleController;
use App\Http\Requests\Settings\Roles\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class UpdateRoleControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_update_role_successfully()
    {
        $oldRoleName = 'writer';
        $newRoleName = 'Article writer';
        $permission = Permission::factory()->create();
        $role = Role::factory()->create([
            'name' => $oldRoleName
        ]);

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($role->id), [
            'name' => $newRoleName,
            'status' => 1,
            'permissions' => [
                $permission->id
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.role')]),
        ]);
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => $newRoleName,
            'guard_name' => 'sanctum',
        ]);
        $this->assertDatabaseHas('role_has_permissions', [
            'role_id' => $role->id,
            'permission_id' => $permission->id
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_super_role()
    {
        $newRoleName = 'Article writer';
        $permission = Permission::factory()->create();

        $response = $this->actingAsSuperUser()->putJson(RoleEnum::SUPER_ROLE->value, [
            'name' => $newRoleName,
            'status' => 1,
            'permissions' => [
                $permission->id
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
        $this->assertDatabaseMissing('roles', [
            'id' => RoleEnum::SUPER_ROLE->value,
            'name' => $newRoleName
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_role_when_it_does_not_exists()
    {
        $newRoleName = 'Article writer';
        $permission = Permission::factory()->create();

        $response = $this->actingAsSuperUser()->putJson(100000, [
            'name' => $newRoleName,
            'status' => 1,
            'permissions' => [
                $permission->id
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
        $this->assertDatabaseMissing('roles', [
            'id' => RoleEnum::SUPER_ROLE->value,
            'name' => $newRoleName
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_role_when_the_user_has_not_permission()
    {
        $user = User::factory()->create();
        $oldRoleName = 'writer';
        $newRoleName = 'Article writer';
        $permission = Permission::factory()->create();
        $role = Role::factory()->create([
            'name' => $oldRoleName
        ]);

        $response = $this->actingAsUser($user)->putJson($this->getRoute($role->id), [
            'name' => $newRoleName,
            'status' => 1,
            'permissions' => [
                $permission->id
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied')
        ]);
    }

    /** @test */
    public function update_roles_has_correct_validation_rules()
    {
        $this->assertEquals([
            'name' => ['required', 'unique:roles,name'],
            'permissions' => ['present', 'array'],
            'status' => ['required', 'in:1,0'],
            'permissions.*' => ['required'],
        ], (new UpdateRoleRequest())->rules());
    }

    /** @test */
    public function update_roles_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(UpdateRoleController::class, '__invoke', UpdateRoleRequest::class);
    }

    private function getRoute(int $roleId)
    {
        return route('settings.v1.roles.update', $roleId);
    }
}
