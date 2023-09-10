<?php

namespace Tests\Feature\Controllers\Settings\V1\Users;

use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

class ShowUserControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_a_user_information_successfully()
    {
        $project = Project::factory()->create([
            'settings' => []
        ]);
        $permission = Permission::factory()->create();
        $role = Role::factory()->hasAttached($permission)->create();
        $user = User::factory()->hasAttached($project)->hasAttached($role)->create();

        $response = $this->actingAsSuperUser()->getJson($this->getRoute($user->id));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user')]),
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'family' => $user->family,
                'username' => $user->username,
                'projects' => [
                    [
                        'id' => $project->id,
                        'title' => $project->project_title,
                        'settings' => []
                    ]
                ],
                'roles' => [
                    [
                        'id' => $role->id,
                        'name' => $role->name,
                        'permissions' => [
                            [
                                'id' => $permission->id,
                                'name' => 'permissions.' . $permission->name,
                                'parent_id' => $permission->parent_id
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_a_user_information()
    {
        $response = $this->getJson($this->getRoute(12));

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_user_that_has_not_exists()
    {
        $response = $this->actingAsSuperUser()->getJson($this->getRoute(3453453453534534354));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_super_user_information()
    {
        $response = $this->actingAsSuperUser()->getJson($this->getRoute(1));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found'),
        ]);
    }

    public function getRoute(int $projectId)
    {
        return route('settings.v1.users.show', $projectId);
    }
}
