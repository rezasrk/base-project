<?php

namespace Tests\Feature\Controllers\Settings\V1\Users;

use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

class IndexUserControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_users_successfully()
    {
        $project = Project::factory()->create([
            'settings' => []
        ]);
        $permission = Permission::factory()->create();
        $role = Role::factory()->hasAttached($permission)->create();
        $user = User::factory()->hasAttached($project)->hasAttached($role)->create();

        $response = $this->actingAsSuperUser()->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user')]),
            'data' => [
                [
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
                ],
            ],
            'pagination_information' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 30,
                'total' => 1,
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_see_users_successfully_with_filter_username()
    {
        $username = 'writer';
        $project = Project::factory()->create([
            'settings' => []
        ]);
        $permission = Permission::factory()->create();
        $role = Role::factory()->hasAttached($permission)->create();
        User::factory()->hasAttached($project)->hasAttached($role)->create([
            'username' => 'admin'
        ]);
        $user = User::factory()->hasAttached($project)->hasAttached($role)->create([
            'username' => $username
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute() . "?username=" . $username);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user')]),
            'data' => [
                [
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
                ],
            ],
            'pagination_information' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 30,
                'total' => 1,
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_see_users_successfully_with_filter_full_name()
    {
        $name = 'Ali';
        $family = 'Mohammad';
        $project = Project::factory()->create([
            'settings' => []
        ]);
        $permission = Permission::factory()->create();
        $role = Role::factory()->hasAttached($permission)->create();
        User::factory()->hasAttached($project)->hasAttached($role)->create([
            'name' => 'admin',
            'family' => 'admin'
        ]);
        $user = User::factory()->hasAttached($project)->hasAttached($role)->create([
            'name' => $name,
            'family' => $family
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute() . "?full_name=" . $name . ' ' . $family);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user')]),
            'data' => [
                [
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
                ],
            ],
            'pagination_information' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 30,
                'total' => 1,
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_see_users_successfully_with_filter_roles()
    {
        $project = Project::factory()->create([
            'settings' => []
        ]);
        $permission = Permission::factory()->create();
        $role = Role::factory()->hasAttached($permission)->create();
        User::factory()->create();
        $user = User::factory()->hasAttached($project)->hasAttached($role)->create();

        $response = $this->actingAsSuperUser()->getJson($this->getRoute() . '?roles=' . $role->id . ',');

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user')]),
            'data' => [
                [
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
                ],
            ],
            'pagination_information' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 30,
                'total' => 1,
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_users_successfully()
    {
        $response = $this->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_users_list_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    private function getRoute(): string
    {
        return route('settings.v1.users.index');
    }
}
