<?php

namespace Tests\Feature\Controllers\Auth;

use App\Http\Controllers\Auth\SelectProjectController;
use App\Http\Requests\Auth\SelectProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class SelectProjectControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_select_project_successfully()
    {
        $project = Project::factory()->create();
        $user = User::factory()->hasAttached($project)->create();

        $response = $this->actingAsUser($user)->postJson($this->getRoute(), [
            'project_id' => $project->id
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.select-project')
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_select_project()
    {
        $project = Project::factory()->create();
        User::factory()->hasAttached($project)->create();

        $response = $this->postJson($this->getRoute(), [
            'project_id' => $project->id
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function select_project_has_correct_rules()
    {
        $this->assertEquals([
            'project_id' => ['required', 'exists:projects,id']
        ], (new SelectProjectRequest())->rules());
    }

    /** @test */
    public function select_project_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(SelectProjectController::class, '__invoke', SelectProjectRequest::class);
    }

    private function getRoute()
    {
        return route('select-project');
    }
}
