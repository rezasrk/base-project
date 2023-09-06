<?php

namespace Tests\Feature\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Settings\V1\Projects\UpdateProjectController;
use App\Http\Requests\Settings\V1\Projects\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class UpdateProjectControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_update_a_project_successfully()
    {
        $oldProjectTitle = 'old-project';
        $newProjectTitle = 'new-project';
        $project = Project::factory()->create([
            'project_title' => $oldProjectTitle
        ]);

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($project->id), [
            'title' => $newProjectTitle
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.project')])
        ]);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'project_title' => $newProjectTitle,
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_update_a_project()
    {
        $response = $this->putJson($this->getRoute(123));

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_a_project_when_the_user_has_not_permission()
    {
        $oldProjectTitle = 'old-project';
        $newProjectTitle = 'new-project';
        $project = Project::factory()->create([
            'project_title' => $oldProjectTitle
        ]);
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->putJson($this->getRoute($project->id), [
            'title' => $newProjectTitle
        ]);

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    /** @test */
    public function update_projects_has_correct_validation_rules()
    {
        $projectId = 54;
        $request = new UpdateProjectRequest();
        $request->setRouteResolver(function () use ($projectId) {
            $route = new Route('put', $this->getRoute($projectId), [UpdateProjectController::class]);
            $route->parameters['id'] =  $projectId;

            return $route;
        });

        $this->assertEquals([
            'title' => ['required', 'unique:projects,project_title,' . $projectId . ',id', 'max:190'],
        ], $request->rules());
    }

    /** @test */
    public function update_projects_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(UpdateProjectController::class, '__invoke', UpdateProjectRequest::class);
    }

    /** @test */
    public function authenticated_user_can_not_update_project_when_project_title_already_exists()
    {
        $oldProjectTitle = 'old-project';
        $newProjectTitle = 'new-project';
        $project = Project::factory()->create([
            'project_title' => $oldProjectTitle
        ]);
        Project::factory()->create([
            'project_title' => $newProjectTitle
        ]);

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($project->id), [
            'title' => $newProjectTitle
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'title' => [
                    __('validation.unique', ['attribute' => 'title'])
                ]
            ]
        ]);
    }

    private function getRoute(int $projectId)
    {
        return route('settings.v1.project.update', $projectId);
    }
}
