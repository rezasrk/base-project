<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class UserProjectsControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_projects_that_have_access_on_it()
    {
        $project = Project::factory()->create();
        $user = User::factory()->hasAttached($project)->create();

        $response = $this->actingAsUser($user)->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user_projects')]),
            'data' => [
                [
                    'id' => $project->id,
                    'title' => $project->project_title,
                ],
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_projects_that_have_not_access_on_it()
    {
        Project::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user_projects')]),
            'data' => [],
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_projects_that_has_access_on_it()
    {
        $projectTitle = 'first_project';
        $project = Project::factory()->create([
            'project_title' => $projectTitle,
        ]);
        $user = User::factory()->hasAttached($project)->create();

        $response = $this->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    private function getRoute()
    {
        return route('user-projects');
    }
}
