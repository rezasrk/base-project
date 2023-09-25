<?php

namespace Tests\Feature\Controllers\Settings\V1\Roles;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class IndexRoleControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_all_roles_list()
    {
        $permission = Permission::factory()->create([
            'name' => 'write',
        ]);
        $role = Role::factory()->hasAttached($permission)->create();

        $response = $this->actingAsSuperUser()->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.role')]),
            'data' => [
                [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => [
                        [
                            'id' => $permission->id,
                            'name' => 'permissions.' . $permission->name,
                            'parent_id' => $permission->parent_id,
                        ],
                    ],
                ],
            ],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 30,
                'total' => 1,
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_all_roles_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_all_roles()
    {
        $response = $this->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    private function getRoute()
    {
        return route('settings.v1.roles.index');
    }
}
