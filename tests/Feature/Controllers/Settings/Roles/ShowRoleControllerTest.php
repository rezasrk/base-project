<?php

namespace Tests\Feature\Controllers\Settings\Roles;

use App\Enum\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class ShowRoleControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_a_special_role_information()
    {
        $permissionName = 'write';
        $permission = Permission::factory()->create([
            'name' => $permissionName,
        ]);
        $role = Role::factory()->hasAttached($permission)->create();

        $response = $this->actingAsSuperUser()->getJson($this->getRoute($role->id));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.role')]),
            'data' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => [
                    [
                        'id' => $permission->id,
                        'name' => 'permissions.'.$permission->name,
                        'parent_id' => $permission->parent_id,
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_super_role()
    {
        $response = $this->actingAsSuperUser()->getJson($this->getRoute(RoleEnum::SUPER_ROLE->value));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_role_when_it_does_not_exists()
    {
        $response = $this->actingAsSuperUser()->getJson($this->getRoute(50000));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
    }

    private function getRoute(int $roleId)
    {
        return route('settings.v1.roles.show', $roleId);
    }
}
